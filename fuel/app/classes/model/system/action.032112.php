<?php

    class Model_System_Action extends \Model{
        
        static function find($id){
            $result = DB::select()->from('actions')->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select()->from('actions')->order_by('name')->execute();
            return $result->as_array();
            
        }
        
        static function findByStatus($status_id){
            
            $result = DB::select('a.id', 'a.name')
                                ->from(array('actions','a'))
                                ->join(array('actions_statuses', 'as'))->on('as.action_id', '=', 'a.id')
                                ->where('as.status_id', '=', $status_id)
                                ->execute();
            
            return $result->as_array();
        }
        
        static function findActionID($action){
            
            if(is_numeric($action)){
                return $action;
            }
            
            $result = DB::select('id')->from('actions')->where('name', '=', $action)->execute();
            $row = current($result->as_array());
            
            return $row['id'];
            
        }
        
        static function add($data){
            $result = DB::insert('actions')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('actions')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('actions')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            return $val;
        }
        
    }