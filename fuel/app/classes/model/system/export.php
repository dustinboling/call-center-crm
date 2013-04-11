<?php

    class Model_System_Export extends Model{
        
        static function find($id){
            $result = DB::select()->from('template_exports')->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select()->from('template_exports')->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            $result = DB::insert('template_exports')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('template_exports')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('template_exports')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            $val->add('type', 'Type')
                ->add_rule('required');

            $val->add('data_template', 'Data Template')
                ->add_rule('required');

            return $val;
        }
        
    }