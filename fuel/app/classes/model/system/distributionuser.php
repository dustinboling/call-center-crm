<?php

    class Model_System_DistributionUser extends Model{
        
        static function set($group_id, $users){
            
            $result = DB::select()->from('distribution_users_groups')->where('group_id','=',$group_id)->execute();

            if(count($result) && !empty($users)){
                $remove = array();
                foreach($result->as_array() as $r){
                    $match = array_search($r['user_id'], $users);

                    if($match !== false){
                        unset($users[$match]);
                    }else{
                        $remove[] = $r['user_id'];
                    }
                }
                
            }elseif(count($result) && empty($users)){
                DB::delete('distribution_users_groups')->where('group_id','=',$group_id)->execute();
                return;
            }
            
            if(!empty($users)){
                foreach($users as $u){
                    DB::insert('distribution_users_groups')->set(array('group_id' => $group_id, 'user_id' => $u))->execute();
                }
            }
            
            if(!empty($remove)){
                DB::delete('distribution_users_groups')->where('group_id','=',$group_id)->where('user_id','in',$remove)->execute();
            }
            
        }
        
        static function findByGroup($id){
            $result = DB::select()->from('distribution_users_groups')->where('group_id','=',$id)->execute();
            return $result->as_array();
        }
        
    }