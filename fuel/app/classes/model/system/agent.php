<?php

    class Model_System_Agent{
        
        static function find($id){
            
            $result = DB::select()->from('agents')->where('id', '=', $id)->execute();
            return current($result->as_array());
            
        }
        static function findAll(){
            
            $result = DB::select()->from('agents')->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            $result = DB::insert('agents')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('agents')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('agents')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('first_name', 'First Name')
                ->add_rule('required');

            $val->add('last_name', 'Last Name')
                ->add_rule('required');

            return $val;
        }
        
        
    }