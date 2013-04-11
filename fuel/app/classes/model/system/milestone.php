<?php

    class Model_System_Milestone{
        
        static function find($id){
            $result = DB::select()->from('milestones')->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select()->from('milestones')->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            $result = DB::insert('milestones')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('milestones')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('milestones')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            return $val;
        }
        
    }