<?php

    namespace ESign;

    class Controller_Document extends Controller_Base{
        
        function action_application($app_id){
            
            $data['forms'] = Model_Form::findESign();
            $data['documents'] = Model_Document::findByAppID($app_id);
            $data['tabs']['customer'] = '';
            $this->response->body = \View::factory('layout', array('l' => 'document/application', 'c' => $data));
            
        }
        
        function action_listing($case_id){
            
            $data['case'] = \Model_Case::find($case_id);
            $data['forms'] = Model_Form::findESign();
            $data['documents'] = Model_Document::findByCaseID($case_id);
            $this->response->body = \View::factory('layout', array('l' => 'document/listing', 'c' => $data));
            
        }
        
        function action_prepare($case_id, $form_id){
            
            $model = 'Esign\Model_Adapter_Form'.$form_id;

            if(!empty($_POST)){
                try{
                    $model::processData($case_id, $_POST);
                    \Notify::success('Document sent for signature');
                    \Response::redirect('/esign/document/listing/'.$case_id);
                }catch(\Exception $e){
                   \Notify::error($e);
                }
            }
            
            $data['fields'] = $model::getFormFields();
            $data['form'] = Model_Form::find($form_id);
            $data['case'] = \Model_Case::find($case_id);
            
            $this->response->body = \View::factory('layout', array('l' => 'document/prepare', 'c' => $data));
        }
        
        function action_download($document_key){
            
            $doc = Model_Document::findByDocumentKey($document_key);
            
            if(empty($doc['case_id'])){
                print "Can't find document key.";
                exit;
            }
            
            $folder = \Config::get('docs_folder').$doc['case_id'].'/';
            mkdir($folder, 0777, true);
            
            $file = $folder.preg_replace('/[^0-9a-z]/i','',$document_key).'.pdf';

            // We'll be outputting a PDF
            header('Content-type: application/pdf');
            
            if(file_exists($file)){

                readfile($file);
                
            }else{
                \Config::load('esign', true);
                require(\PKGPATH.'echosign/bootstrap.php');
                $echosign = new \EchoSignAPI(\Config::get('esign.api_key'));
                
                $result = $echosign->getLatestDocument($document_key);

                
                $handle = fopen($file,'wb+');
                fwrite($handle, $result->pdf);
                fclose($handle);

                print $result->pdf;
                
            }
            
        }
        
    }