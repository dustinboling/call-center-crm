<?php

    class Model_System_Communication extends \Model{
        
        static function find($id){
            
            $result = DB::select()->from('template_communications')->where('id', '=', $id)->execute();
            return current($result->as_array());
            
        }
        static function findAll(){
            
            $result = DB::select()->from('template_communications')->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            $result = DB::insert('template_communications')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('template_communications')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('template_communications')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            return $val;
        }
        
    }