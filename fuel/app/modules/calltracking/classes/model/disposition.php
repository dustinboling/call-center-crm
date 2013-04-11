<?php

    namespace CallTracking;

    class Model_Disposition extends \Model{
        
        static function findAll(){
            
            $result = \DB::select()->from('ct_dispositions')->where('org_id', '=', $_SESSION['user']['org_id'])->order_by('name')->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            
            $data['org_id'] = $_SESSION['user']['org_id'];
            list($insert_id, $rows_affected) = \DB::insert('ct_dispositions')->set($data)->execute();
            return $insert_id;
            
        }
        
        static function update($id, $data){
            
            \DB::update('ct_dispositions')->set($data)->where('org_id', '=', $_SESSION['user']['org_id'])->where('id', '=', $id)->execute();
            
        }
        
        static function delete($id){
            
            \DB::delete('ct_dispositions')->where('org_id', '=', $_SESSION['user']['org_id'])->where('id', '=', $id)->execute();
            \DB::update('ct_calls')->set(array('disposition' => 0))->where('disposition', '=', $id)->where('org_id', '=', $_SESSION['user']['org_id']);
        }
        
    }