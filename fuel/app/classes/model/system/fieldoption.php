<?php

    class Model_System_FieldOption{
        
        static function find($id){
            $result = DB::select()->from('object_field_options')->where('id', '=', $id)->execute();
            
            return current($result->as_array());
        }
        
        static function findByField($field_id){
            
            $result = DB::select()->from('object_field_options')->where('object_field_id', '=', $field_id)->order_by('sort')->execute();
            
            return $result->as_array();
            
        } 
        
        static function add($data){
            
            $result = DB::insert('object_field_options')->set($data)->execute();
            
        }
        
        static function update($id, $data){
            
            $result = DB::update('object_field_options')->set($data)->where('id', '=', $id)->execute();
            
        }
        
        static function delete($id){

            DB::delete('object_field_options')->where('id','=', $id)->execute();

        }
        
        static function resort($sorts){
            
            foreach($sorts as $id => $sort){
                DB::update('object_field_options')->set(array('sort' => $sort))->where('id','=', $id)->execute();
            }
            
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('value', 'Value')
                ->add_rule('required');

            return $val;
        }
        
    }