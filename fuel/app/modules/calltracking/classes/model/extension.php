<?php

    namespace CallTracking;

    class Model_Extension extends \Model{
        
        static function find($id){
            
            $result = \DB::select()->from('ct_extensions')->where('id', '=', $id)->execute();
            return current($result->as_array());
            
        }
        
        static function findAll(){
            
            $result = \DB::select()->from('ct_extensions')->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            
            $result = \DB::insert('ct_extensions')->set($data)->execute();
            return current($result);
            
        }
        
        static function update($id, $data){
            
            $result = \DB::update('ct_extensions')->set($data)->where('id', '=', $id)->execute();
            
        }
        
        static function delete($id){
            \DB::delete('ct_extensions')->where('id', '=', $id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');
            
            $val->add('extension', 'Extension')
                ->add_rule('required');

            return $val;
        }
        
    }