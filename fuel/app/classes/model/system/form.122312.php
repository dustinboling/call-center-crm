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
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            return $val;
        }
        
    }