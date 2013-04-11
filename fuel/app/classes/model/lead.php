<?php

    class Model_Lead extends Model{
        
        static function find($id){
            
            $result = DB::select_array(self::getFields())->from(array('applications', 'a'))
                            ->join(array('users', 'u'))->on('u.id', '=', 'a.user_id')
                            ->join(array('client_profiles', 'cp'))->on('cp.id', '=', 'a.user_id')
                            ->where('a.type', '=', 'lead')
                            ->where('a.id', '=', $id)
                            ->where('a.active', '=', 1)
                            ->execute();
            
            return current($result->as_array());
            
        }
        
        static function findAll($offset = 0, $limit = 25){
            
            $result = DB::select_array(self::getFields())->from(array('applications', 'a'))
                            ->join(array('users', 'u'))->on('u.id', '=', 'a.user_id')
                            ->join(array('client_profiles', 'cp'))->on('cp.id', '=', 'a.user_id')
                            ->where('a.type', '=', 'lead')
                            ->where('a.active', '=', 1)
                            ->offset($offset)
                            ->limit($limit)
                            ->execute();
            
            return $result->as_array();
            
        }
        
        static function countAll(){
            
            $result = DB::select(DB::expr('count(id) as total_items'))->from('applications')->where('type','=','lead')->where('active', '=', 1)->execute();
            $row = current($result->as_array());
            return $row['total_items']; 
            
        }
        
        static function getFields($group = 'default'){
            
            switch($group){
                
                case 'default':
                     return array('a.id','u.first_name', 'u.last_name', 'a.phone_home', 'a.current_status', 'cp.phone_home');
                    
                
            }
            
        }
        
    }