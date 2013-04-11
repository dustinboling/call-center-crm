<?php

    namespace ESign;

    class Model_Adapter_Form extends \Model{

        static protected $form_id = null;
        
        static function setFormID($form_id){
            static::$form_id = $form_id;
        }
        
        static function saveDocument($case_id, $document_key){
            
            $data = array(
                            'case_id' => $case_id,
                            'form_id' => static::$form_id,
                            'document_key' => $document_key,
                            'created' => date('Y-m-d H:i:s')
                         );
            
            Model_Document::add($data);
            \Model_Case::updateBase($case_id, array('docs_status' => 'Sent'));
        }
        
        static function previewDocument($file, $data){
            
            $xfdf = simplexml_load_string('<xfdf xmlns="http://ns.adobe.com/xfdf/" xml:space="preserve" />');
            $fields = $xfdf->addChild('fields');
            
            foreach($data as $k => $v){
                $field = $fields->addChild('field');
                $field->addAttribute('name', $k);
                $field->addChild('value', str_replace('&', '&amp;', html_entity_decode($v))); 
            }
            
            $folder = '../tmp/xfdf/'.date('mdy').'/';
            @mkdir($folder, 0777, true);
            
            $xfdf_file = $folder.sha1(microtime().range(0, 100000));
            $pdf_file = $xfdf_file.'.pdf';
            
            $f = fopen($xfdf_file.'.xfdf','w+');
            fwrite($f, $xfdf->asXML());
            fclose($f);

            exec("pdftk {$file} fill_form {$xfdf_file}.xfdf output ".$pdf_file);
            
            unlink($xfdf_file);
            
            $filename = substr($pdf_file, strrpos($pdf_file,'/')+1);;
            
            header('Content-type: application/pdf');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header("Cache-Control: no-cache, must-revalidate"); 
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
            readfile($pdf_file);
            
            unlink($pdf_file);
            
        }
        
        static function parseDataFields($case_id){
            
            $form = \Model_System_Form::find(static::$form_id);
            $case = \Model_Case::find($case_id);

            parse_str($form['data_template'], $template);
            
              print '<pre>';
            print_r($template);
            exit;          
            
            $phone_fields = \Model_System_ObjectFields::findByType(1, 10);
            $pf = array();
            foreach($phone_fields as $p){
                $pf[$p['clean_name']] = $p['clean_name'];
            }

            $data = array();
            foreach($template as $k => $v){
                if(isset($case[$v])){
                    //if it's a phone field, clean it
                    $data[$k] = (in_array($k, $pf)? preg_replace('/[^0-9]/','', $case[$v]):$case[$v]);
                }
            }
            
            print '<pre>';
            print_r($data);
            exit;
        }
        
    }