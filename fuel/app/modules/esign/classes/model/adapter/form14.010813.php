<?php

    namespace ESign;

    class Model_Adapter_Form14 extends Model_Adapter_FormBase{
        
        static protected $form_id = 14;

        static function processData($case_id, $data){
                
                \Config::load('esign', true);
            
                $form = \Model_System_Form::find(static::$form_id);
                $case = \Model_Case::find($case_id);

                parse_str($form['data_template'], $template);

                $form_data = \Model_System_ObjectFields::parseTemplate($template, $case);
                
                $payments = \Model_Payment::findByCaseID($case_id);
            
                $l = 1;
                foreach($payments as $p){
                    $form_data['Payment'.$l.'_Date'] = date('m/d/Y', strtotime($p['date_due']));
                    $form_data['Payment'.$l.'_Amount'] = '$'.$p['amount'];
                    $l++;
                }

                $state_tax_years = array();
                $federal_tax_years = array();

                if(isset($case['federal_not_filed']) && is_array($case['federal_not_filed'])){ $federal_tax_years = array_merge($federal_tax_years, $case['federal_not_filed']); }
                if(isset($case['federal_owed']) && is_array($case['federal_owed'])){ $federal_tax_years = array_merge($federal_tax_years, $case['federal_owed']); }
                if(isset($case['state_not_filed']) && is_array($case['state_not_filed'])){ $state_tax_years = array_merge($state_tax_years, $case['state_not_filed']); }
                if(isset($case['state_owed']) && is_array($case['state_owed'])){ $state_tax_years = array_merge($state_tax_years, $case['state_owed']); }

                $federal_tax_years = array_unique($federal_tax_years);
                asort($federal_tax_years);
                
                $state_tax_years = array_unique($state_tax_years);
                asort($state_tax_years);

                $form_data['Tax_Dates_Fed'] = implode(',', $federal_tax_years);
                $form_data['Tax_Dates_State'] = implode(',', $state_tax_years);
                
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
                $recipients->add($case['email']);

                $package = new \EchoSignDocumentPackage($document, $recipients);
                $package->setCallbackInfo('http://'.$_SERVER['HTTP_HOST'].'/api/document_status');

                $result = $echosign->sendDocument($package);

                $document_key = (string)$result->documentKeys->DocumentKey->documentKey;

                self::saveDocument($case_id, $document_key);
            }
    }    
