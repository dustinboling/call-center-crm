<?php

    class Model_System_Action extends \Model{
        
        static function find($id){
            $result = DB::select()->from('actions')->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select('a.*', array('g.name', 'group'))
                    ->from(array('actions', 'a'))
                    ->join(array('action_groups', 'g'), 'LEFT')->on('a.group_id', '=', 'g.id')
                    ->execute();
            
            return $result->as_array();
            
        }
        
        static function findByStatus($status_id){
            
            $result = DB::select('a.*')
                                ->from(array('actions','a'))
                                ->join(array('actions_statuses', 'as'))->on('as.action_id', '=', 'a.id')
                                ->where('as.status_id', '=', $status_id)->order_by('view_id')
                                ->execute();
            
            return $result->as_array();
        }
        
        static function findIDsByGroup($group_id){
            
            $result = DB::select('id')->from('actions')->where('group_id', '=', $group_id)->execute();
            
            $ids = array();
            foreach($result->as_array() as $r){
                $ids[] = $r['id'];
            }
            
            return $ids;
        }
        
        static function findActionID($action){
            
            if(is_numeric($action)){
                return $action;
            }
            
            $result = DB::select('id')->from('actions')->where('name', '=', $action)->execute();
            $row = current($result->as_array());
            
            return $row['id'];
            
        }
   
        static function findInBatch(){
        
        	$result = DB::select()->from('actions')->order_by('name')
        	->where('in_batch', '=', '1')
        	->execute();
        	return $result->as_array();
        
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