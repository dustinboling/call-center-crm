<?php

    class Model_System_Event extends Model{
        
        static function find($id){
            $result = DB::select()->from('template_events')->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select()->from('template_events')->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            $result = DB::insert('template_events')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('template_events')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('template_events')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            $val->add('title', 'Title')
                ->add_rule('required');

            $val->add('when', 'when')
                ->add_rule('required');

            $val->add('assign_to', 'assign_to')
                ->add_rule('required');

            return $val;
        }
        
    }