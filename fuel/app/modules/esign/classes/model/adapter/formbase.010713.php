<?php

    namespace ESign;

    class Model_Adapter_FormBase extends Model_Adapter_Form{
        
        static protected $form_id = null;
        
        static function getFormFields(){
            return '';
        }
        
        static function processData($case_id, $data){

            $form = \Model_System_Form::find(static::$form_id);
            $case = \Model_Case::find($case_id);
            
            parse_str($form['data_template'], $template);
            
            $form_data = \Model_System_ObjectFields::parseTemplate($template, $case);
            
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