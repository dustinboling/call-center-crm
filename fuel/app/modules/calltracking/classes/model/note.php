<?php

    namespace CallTracking;

    class Model_Note extends \Model{
        
        static function findByCallID($call_id){
            
            $result = \DB::select()
                            ->from('ct_notes')
                            ->where('org_id', '=', $_SESSION['user']['org_id'])
                            ->where('call_id', '=', $call_id)
                            ->order_by('created')
                            ->execute();
            
            return $result->as_array();
            
        }
        
        static function add($data){
            
            
            $meta = array(
                            'org_id' => $_SESSION['user']['org_id'],
                            'user_id' => $_SESSION['user']['id'],
                            'created' => date('Y-m-d H:i:s')
                         );
            
            $data = array_merge($data, $meta);
            
            list($insert_id, $rows_affected) = \DB::insert('ct_notes')->set($data)->execute();
            
            Model_Call::increment_notes($data['call_id']);
            
            return array('id' => $insert_id, 'date' => \format::relative_date('now'));
            
        }
        
        static function update($id, $data){
            
            \DB::update('ct_notes')->set($data)->where('org_id', '=', $_SESSION['user']['org_id'])->where('id', '=', $id)->execute();
            
        }
        
        static function delete($id){
            
            $result = \DB::select('call_id')->from('ct_notes')->where('id', '=', $id)->execute();
            $row = current($result->as_array());
            
            \DB::delete('ct_notes')->where('org_id', '=', $_SESSION['user']['org_id'])->where('id', '=', $id)->execute();
            
            Model_Call::decrement_notes($row['call_id']);
            
        }
        
        static function getNotesExport($calls){
            
            $ids = array();
            foreach($calls as $call){
                $ids[] = $call['id'];
            }
            
            $result = \DB::select('call_id','created','note')->from('ct_notes')->where('call_id', 'IN', $ids)->execute();

            $notes = array();
            foreach($result->as_array() as $row){
                $notes[$row['call_id']][] = (strtotime($row['created']) ? date('m/d/y g:ia', strtotime($row['created'])).' - ':'') . $row['note'];
            }
            
            return $notes;
            
        }
        
    }