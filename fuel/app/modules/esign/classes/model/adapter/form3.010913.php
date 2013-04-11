<?php

    namespace ESign;

    class Model_Adapter_Form3 extends Model_Adapter_Form{
        
        static protected $form_id = 3;
        
        static function getFormFields(){
            
            $view['agents'] = \Model_System_Agent::findAll();
            return \View::factory('document/adapter_fields/form3', $view)->render();
            
        }
        
        static function processData($case_id, $data){
            
            \Config::load('esign', true);

            $form = \Model_System_Form::find(static::$form_id);
            $case = \Model_Case::find($case_id);
            
            parse_str($form['data_template'], $template);
            
            $signers = array($case['email'], $case['spouse_email']);
            if($data['parties'] == 'contact'){
                $signers = array($case['email']);
                if(isset($template['name_address'])){
                    $template['name_address'] = str_replace("\r\n \r\n", "\r\n", str_replace(array('{spouse_first_name}','{spouse_last_name}'), '', $template['name_address']));
                }
            }elseif($data['parties'] == 'spouse'){
                $signers = array($case['spouse_email']);
                $template['ssn'] = str_replace('{ssn}', '{spouse_ssn}', $template['ssn']);
                $template['day_phone'] = str_replace('{primary_phone}', '{spouse_primary_phone}', $template['day_phone']);
                if(isset($template['name_address'])){
                    $template['name_address'] = trim(str_replace(array('{first_name}','{last_name}'), '', $template['name_address']));
                }
            }
            
            $form_data = \Model_System_ObjectFields::parseTemplate($template, $case);
            
            $agent = \Model_System_Agent::find($data['agent']);
            $form_data = array_merge($form_data, self::agentRecordToArray($agent));
            
            if($data['prepare'] == 'Preview'){
                self::previewDocument(DOCROOT.'pdfs/'.$form['file'], $form_data);
                exit;
            }
            
            require(PKGPATH.'echosign/bootstrap.php');
            $echosign = new \EchoSignAPI(\Config::get('esign.api_key'));
            
            $document = new \EchoSignDocument($form['name'], 'pdfs/'.$form['file']);
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
        
        static function agentRecordToArray($r){
            
            return array(
                            'f8821_agent_name_address' => $r['first_name']. ' ' . $r['last_name']. "\r\n" . $r['address'],
                            'f8821_agent_caf' => $r['caf'],
                            'f8821_agent_phone' => \format::phone($r['phone']),
                            'f8821_agent_fax' => \format::phone($r['fax'])
                        );
            
        }
        
    }