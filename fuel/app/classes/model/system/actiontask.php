<?php

    class Model_System_ActionTask extends \Model{
        
        static function findTypes(){
            
            $result = DB::select()->from('action_tasks')->execute();
            return $result->as_array();
            
        }
        
        static function findTargets($task_id){
            
            $result = DB::select()->from('action_tasks')->where('id', '=', $task_id)->execute();
            
            if(!count($result)){
                return array();
            }
            
            $row = current($result->as_array());
            
            if(empty($row['options_table'])){
                return array();
            }
            
            $query = DB::select('id', 'name')->from($row['options_table']);
            
            if($row['options_table'] == 'statuses'){
                $query->where('active', '=', 1);
            }
            
            $result = $query->execute();
            
            return $result->as_array();
            
        }
        
        static function find($id){
            
            $result = DB::select()->from('actions_tasks')->where('id', '=', $id)->execute();
            return current($result->as_array());
            
        }
        
        static function findByActionID($action_id){
            
            $result = DB::select('ast.id','ast.action_id','ast.task_id','ast.target_id','at.name','at.options_table')
                    ->from(array('actions_tasks', 'ast'))
                    ->join(array('action_tasks', 'at'))->on('ast.task_id', '=', 'at.id')
                    ->where('action_id', '=', $action_id)
                    ->execute();
            
            $tasks = array();
            $tables = array();
            foreach($result->as_array() as $row){
                $tasks[$row['id']] = $row;
                $tables[$row['options_table']][] = $row['target_id'];
            }
            
            $names = array();
            foreach($tables as $table => $ids){
                $task_res = DB::select('id', 'name')->from($table)->where('id', 'IN', $ids)->execute();
                foreach($task_res->as_array() as $row){
                    $names[$table][$row['id']] = $row['name'];
                }
            }
            
            foreach($tasks as $id => $t){
                $tasks[$id]['target'] = $names[$t['options_table']][$t['target_id']];
            }
            
            return $tasks;
            
        }
        
         static function add($data){
            $result = DB::insert('actions_tasks')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('actions_tasks')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('actions_tasks')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('task_id', 'Task')
                ->add_rule('required');

            $val->add('target_id', 'Target')
                ->add_rule('required');

            return $val;
        }
        
    }