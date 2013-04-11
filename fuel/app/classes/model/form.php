<?php

    class Model_Form extends Model{
        
        static function find($id){
            $result = DB::select()->from('forms')->where('id', '=', $id)->where('active', '=', 1)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select()->from('forms')->where('active', '=', 1)->execute();
            return $result->as_array();
            
        }
        
        static function generate($form_id, $case_id){
            
            $form = Model_System_Form::find($form_id);
            $case = Model_Case::find($case_id);
            $data = Model_System_ObjectFields::parseTemplate($form['data_template'], $case);
           
            $xfdf = simplexml_load_string('<xfdf xmlns="http://ns.adobe.com/xfdf/" xml:space="preserve" />');
            $fields = $xfdf->addChild('fields');
            
            foreach($data as $k => $v){
                $field = $fields->addChild('field');
                $field->addAttribute('name', $k);
                $field->addChild('value', str_replace('&', '&amp;', html_entity_decode($v))); 
            }
            
            $xfdf_file = '../tmp/xfdf/'.$form_id.'_'.$case_id.'_'.time();
            $f = fopen($xfdf_file,'w+');
            fwrite($f, $xfdf->asXML());
            fclose($f);
            
            $pdf_folder = Config::get('completed_form_folder').$case_id."/";
            if(!is_dir($pdf_folder)){
                mkdir($pdf_folder, 0777, true);
            }

            $pdf_file = $pdf_folder.str_replace('.pdf','',$form['file']).'_'.time().".pdf";
            
            exec("pdftk ".Config::get('blank_form_folder')."{$form['file']} fill_form {$xfdf_file} output ".$pdf_file);
            
            unlink($xfdf_file);
            
            return $pdf_file;
            
        }
        
    }