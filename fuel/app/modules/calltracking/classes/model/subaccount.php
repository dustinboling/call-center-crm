<?php

    namespace CallTracking;

    class Model_Subaccount extends \Model{
        
        static function findAll(){
            
            $result = \DB::select()->from('ct_subaccounts')->where('org_id', '=', $_SESSION['user']['org_id'])->order_by('company')->execute();
            return $result->as_array();
            
        }
        
        static function find($id){
            
            $result = \DB::select()->from('ct_subaccounts')->where('org_id', '=', $_SESSION['user']['org_id'])->where('id', '=', $id)->execute();
            return current($result->as_array());
            
        }
        
        static function add($data){
            
            $data['org_id'] = $_SESSION['user']['org_id'];
            list($insert_id, $rows_affected) = \DB::insert('ct_subaccounts')->set($data)->execute();
            return $insert_id;
            
        }
        
        static function update($id, $data){
            
            \DB::update('ct_subaccounts')->set($data)->where('org_id', '=', $_SESSION['user']['org_id'])->where('id', '=', $id)->execute();
            
        }
        
        static function delete($id){
            
            \DB::delete('ct_subaccounts')->where('org_id', '=', $_SESSION['user']['org_id'])->where('id', '=', $id)->execute();
            
        }
        
    }