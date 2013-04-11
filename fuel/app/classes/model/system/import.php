<?php

    class Model_System_Import extends Model{
        
        static function find($id){
            $result = DB::select()->from('template_imports')->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select()->from('template_imports')->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            $data['hash'] = sha1(md5(microtime()).microtime());
            $result = DB::insert('template_imports')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('template_imports')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('template_imports')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            $val->add('data_template', 'Data Template')
                ->add_rule('required');

            return $val;
        }
        
    }