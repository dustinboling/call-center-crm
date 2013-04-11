<?php

    class Model_Log extends Model{
        
        static function addActivity($case_id, $type, $message, $note = '', $user_id = 0){
            
            $data = array(
                          'case_id' => $case_id,
                          'message' => $message,
                          'note' => $note,
                          'type' => $type,
                          'by' => (!empty($_SESSION['user']['id'])&& empty($user_id)?$_SESSION['user']['id']:$user_id),
                          'ts' => date('Y-m-d H:i:s')
                         );
            
            $result = \DB::insert('log_activity')->set($data)->execute();
            return current($result);
            
        }
        
        static function findActivity($case_id, $type = null, $limit = null){
            
            $result = DB::select(DB::expr('CONCAT(u.first_name, " ", u.last_name) as name'), 'a.message','a.note', 'a.ts')
                            ->from(array('log_activity','a'))
                            ->join(array('users', 'u'), 'left')->on('u.id', '=', 'a.by')
                            ->where('a.case_id', '=', $case_id)
                            ->order_by('a.id', 'DESC');
            
            if(!empty($type)){
                $result->where('a.type', '=', $type);
            }
            
            if(!empty($limit)){
                $result->limit($limit);
            }
            
            $result = $result->execute();
            
            return $result->as_array();
            
        }
        
        static function addImport($type, $content){
            
            $data = array(
                            'uri' => $_SERVER['REQUEST_URI'],
                            'type' => $type,
                            'content' => $content,
                            'ip' => ip2long($_SERVER['REMOTE_ADDR']),
                            'ts' => date("Y-m-d H:i:s")
                         );
             
            $result = DB::insert('log_imports')->set($data)->execute();
            
        }
        
        static function trackAction($type, $user_id, $case_id, $action_id, $action_group_id){
            
            if(!empty($action_group_id) && $type == 'first_group'){
                $action_ids = Model_System_Action::findIDsByGroup($action_group_id);
                $result = DB::select('id')->from('log_actions')->where('case_id','=',$case_id)->where('action_id', 'in', $action_ids)->execute();
            }else{
                $result = DB::select('id')->from('log_actions')->where('case_id','=',$case_id)->where('action_id','=',$action_id)->execute();
            }

            $first = 0;
            if(in_array($type, array('first','first_group'))){
                $first = 1;
                if(count($result)){
                    return;
                }
            }else{
                if(!count($result)){
                    $first = 1;
                }
            }

            
            $data = array(
                          'case_id' => $case_id,
                          'action_id' => $action_id,
                          'user_id' => $user_id,
                          'first' => $first
                         );
            
            $result = \DB::insert('log_actions')->set($data)->execute();
            return current($result);
            
        }
        
    }