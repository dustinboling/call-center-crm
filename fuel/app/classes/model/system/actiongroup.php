<?php

    class Model_System_ActionGroup extends \Model{
                
        static function find($id){
            
            $result = DB::select()->from('action_groups')->where('id', '=', $id)->execute();
            return current($result->as_array());
            
        }
                
        static function findAll(){
            
            $result = DB::select()->from('action_groups')->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            $result = DB::insert('action_groups')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('action_groups')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('action_groups')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            return $val;
        }
        
    }