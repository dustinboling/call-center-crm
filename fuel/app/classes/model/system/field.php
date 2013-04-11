<?php

    class Model_System_Field extends Model{
        
        static function find($id){
            $result = DB::select()->from('object_fields')->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select('f.id', 'f.name', 'f.clean_name', 't.structure')->from(array('object_fields','f'))->join(array('object_field_types','t'))->on('f.field_type_id', '=','t.id')->execute();
            return $result->as_array();
            
        }
        
        static function findAllTypes(){
            $result = DB::select()->from('object_field_types')->execute();
            return $result->as_array();
        }
        
        static function add($data){
            $result = DB::insert('object_fields')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('object_fields')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('object_fields')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            $val->add('field_type_id', 'Field Type')
                ->add_rule('required');

            return $val;
        }
        
    }