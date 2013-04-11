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
        
    }