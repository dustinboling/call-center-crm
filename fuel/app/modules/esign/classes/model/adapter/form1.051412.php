<?php

    namespace ESign;

    class Model_Adapter_Form1 extends Model_Adapter_Form{
        
        static protected $form_id = 1;
        
        static function getFormFields(){
            
            $view['agents'] = \Model_System_Agent::findAll();
            return \View::factory('document/adapter_fields/form1', $view)->render();
            
        }
        
        static function processData($case_id, $data){
            
            \Config::load('esign', true);

            $form = \Model_System_Form::find(static::$form_id);
            $case = \Model_Case::find($case_id);
            
            parse_str($form['data_template'], $template);
            
            $signers = array($case['email'], $case['spouse_email']);
            if($data['parties'] == 'contact'){
                $signers = array($case['email']);
                $template['name_address'] = str_replace("\r\n \r\n", "\r\n", str_replace(array('{spouse_first_name}','{spouse_last_name}'), '', $template['name_address']));
            }elseif($data['parties'] == 'spouse'){
                $signers = array($case['spouse_email']);
                $template['ssn'] = str_replace('{ssn}', '{spouse_ssn}', $template['ssn']);
                $template['day_phone'] = str_replace('{primary_phone}', '{spouse_primary_phone}', $template['day_phone']);
                $template['name_address'] = trim(str_replace(array('{first_name}','{last_name}'), '', $template['name_address']));
            }
            
            $form_data = \Model_System_ObjectFields::parseTemplate($template, $case);
            
            $agent_list = \Model_System_Agent::findAll();
            $agents = array();
            foreach($agent_list as $a){
                $agents[$a['id']] = $a;
            }
            unset($agent_list);
            
            $form_data = array_merge($form_data, Model_Adapter_Form3::agentRecordToArray($agents[$data['f8821_agent']]));
            
            for($i=1;$i<4;$i++){
                if(!empty($data['f2848_agent_'.$i])){
                    $form_data = array_merge($form_data, Model_Adapter_Form2::agentRecordToArray($agents[$data['f2848_agent_'.$i]], $i));
                }
            }
            
            $payments = \Model_Payment::findByCaseID($case_id);
            
            $l = 1;
            foreach($payments as $p){
                $form_data['fee_date_'.$l] = date('m/d/Y', strtotime($p['date_due']));
                $form_data['fee_amount_'.$l] = '$'.$p['amount'];
                $l++;
            }
            
            if($data['prepare'] == 'Preview'){
                self::previewDocument(DOCROOT.'pdfs/'.$form['file'], $form_data);
                exit;
            }
            
            require(PKGPATH.'echosign/bootstrap.php');
            $echosign = new \EchoSignAPI(\Config::get('esign.api_key'));
            
            $document = new \EchoSignDocument('Pinnacle Tax Advisors Service Agreement', 'pdfs/'.$form['file']);
            $merge_fields = new \EchoSignMergeFields();
            
            foreach($form_data as $key => $value){
                $merge_fields->add($key, $value);
            }
            
            $document->setMergeFields($merge_fields);
            
            $recipients = new \EchoSignRecipients;
            
            foreach($signers as $email){
                $recipients->add($email);
            }
            
            $package = new \EchoSignDocumentPackage($document, $recipients);
            $package->setCallbackInfo('http://'.$_SERVER['HTTP_HOST'].'/api/document_status');
            
            $result = $echosign->sendDocument($package);
            
            $document_key = (string)$result->documentKeys->DocumentKey->documentKey;
            
            self::saveDocument($case_id, $document_key);
            
        }
        
    }