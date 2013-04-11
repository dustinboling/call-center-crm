<?php

    class Model_System_Form extends \Model{
        
        static function find($id){
            
            $result = DB::select()->from('forms')->where('id', '=', $id)->execute();
            return current($result->as_array());
            
        }
        static function findAll(){
            
            $result = DB::select()->from('forms')->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            $result = DB::insert('forms')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('forms')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('forms')->where('id','=',$id)->execute();
        }
        
        static function saveFile($name, $files_array){
            
            $parts = pathinfo($files_array['name']);
            $file = preg_replace('/[^0-9a-z-_]/i', '', str_replace(' ', '-', strtolower($name))).'_'.date('mdy').'.'.$parts['extension'];
            
            $form_folder = Config::get('blank_form_folder');
            
            if(file_exists($form_folder.$file)){
                unlink($form_folder.$file);
            }
            
            $result = move_uploaded_file($files_array['tmp_name'], $form_folder.$file);
            
            if(!$result){
                throw new Exception('Could not save file');
            }
            
            return $file;
            
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            return $val;
        }
        
    }