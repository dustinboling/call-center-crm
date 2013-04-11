<?php

    class Model_System_DistributionGroup extends Model{
        
        static function findAll(){
            
            $result = DB::select()->from('distribution_user_groups')->execute();
            return $result->as_array();
            
        }
        
        static function find($id){
            
            $result = DB::select()->from('distribution_user_groups')->where('id','=',$id)->execute();
            return current($result->as_array());
            
        }
        
        static function add($data){
            
            $users = array();
            if(isset($data['users'])){
                $users = $data['users'];
                unset($data['users']);
            }
            
            $result = DB::insert('distribution_user_groups')->set($data)->execute();
            
            if(!empty($users)){
                Model_System_DistributionUser::set($result[0], $users);
            }
            
        }
        
        static function update($id, $data){
            
            $users = array();
            if(isset($data['users'])){
                $users = $data['users'];
                unset($data['users']);
            }
            
            DB::update('distribution_user_groups')->set($data)->where('id','=',$id)->execute();
            Model_System_DistributionUser::set($id, $users);
            
        }
        
        static function delete($id){
            
            DB::delete('distribution_user_groups')->where('id','=',$id)->execute();
            DB::delete('distribution_users_groups')->where('group_id','=',$id)->execute();
            
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            return $val;
            
        }
        
    }