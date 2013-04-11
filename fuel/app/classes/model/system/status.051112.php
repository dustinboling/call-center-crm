<?php

    class Model_System_Status extends Model{
        
        static function find($id){
            
            $result = DB::select()->from('statuses')->where('id', '=', $id)->execute();
            return current($result->as_array());
            
        }
        
        static function findAll($group_id){
            
            $result = DB::select()->from('statuses')->where('group_id', '=', $group_id)->where('active', '=', 1)->order_by('sort')->execute();
            return $result->as_array();
            
        }
        
        static function resort($id, $new_position){
            $status = self::find($id);
            if($status['sort'] > $new_position){
                DB::update('statuses')->set(array('sort' => DB::expr('sort+1')))->where('group_id', '=', $status['group_id'])->where('active', '=', 1)->where('sort', '<', $status['sort'])->execute();
            }else{
                DB::update('statuses')->set(array('sort' => DB::expr('sort-1')))->where('group_id', '=', $status['group_id'])->where('active', '=', 1)->where('sort', '<=', $new_position)->execute();
            }
            print DB::last_query();
            DB::update('statuses')->set(array('sort' => $new_position))->where('id', '=', $id)->execute();
            print DB::last_query();
        }
        
        static function add($data){
            $action_ids = $data['action_ids'];
            unset($data['action_ids']);
            
            $result = DB::select(array(DB::expr('MAX(sort)+1'), 'sort'))->from('statuses')->where('group_id','=',$data['group_id'])->execute();
            $sort = current($result->as_array());

            if(empty($sort['sort'])){
                $sort['sort'] = 1;
            }
            
            $data['sort'] = $sort['sort'];
            $result = DB::insert('statuses')->set($data)->execute();
            $status_id = current($result);
            
            self::manageActions($status_id, $action_ids);
            return $status_id;
        }
        
        static function update($id, $data){
            
            self::manageActions($id, $data['action_ids']);
            unset($data['action_ids']);
            
            $result = DB::update('statuses')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $status = self::find($id);
            DB::update('statuses')->set(array('sort' => DB::expr('sort-1')))->where('sort','>',$status['sort'])->execute();
            $result = DB::update('statuses')->set(array('active' => 0, 'sort' => 0))->where('id','=',$id)->execute();
        }
        
        static function getActions($status_id){
            
            $result = DB::select('action_id')->from('actions_statuses')->where('status_id', '=', $status_id)->execute();
            
            $ids = array();
            foreach($result->as_array() as $row){
                $ids[] = $row['action_id'];
            }
            
            return $ids;
            
        }
        
        static function manageActions($status_id, $action_ids){
            
            DB::delete('actions_statuses')->where('status_id', '=', $status_id)->execute();
            
            foreach($action_ids as $id){
                $data = array('status_id' => $status_id, 'action_id' => $id);
                DB::insert('actions_statuses')->set($data)->execute();
            }
            
        }
        
        static function findAllGroups(){
            
            $result = DB::select()->from('status_groups')->execute();
            return $result->as_array();
            
        }
        
        static function findGroup($id){
            
            $result = DB::select()->from('status_groups')->where('id', '=', $id)->execute();
            return current($result->as_array());
            
        }
        
        static function findByName($name){
            
            $result = DB::select()->from('statuses')->where('name', '=', $name)->execute();
            if(count($result)){
                return current($result->as_array());
            }else{
                return array();
            }
        }
        
        static function findExpiryRules(){
            $result = DB::select('id','name','expiry_days','expiry_action_id')->from('statuses')->where('active','=',1)->where('expiry_days', '>', 1)->where('expiry_action_id', '>', 1)->execute();
            
            $rules = array();
            foreach($result->as_array() as $row){
                $rules[$row['id']] = $row;
            }
            
            return $rules;
            
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            $val->add('level', 'Level')
                ->add_rule('required');

            return $val;
        }
        
    }