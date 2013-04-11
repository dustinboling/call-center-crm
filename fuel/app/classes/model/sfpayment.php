<?php

    class Model_SFPayment extends Model{
        
        static function findByTransactionID($transaction_id){
            
            $result = DB::select()->from('sf_payments')->where('transaction_id','=',$transaction_id)->limit(1)->execute();
            return $result->as_array();
            
        }
        
        static function findByCase($case_id){
            
            $result = DB::select()->from('sf_payments')->where('case_id','=',$case_id)->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            $result = DB::insert('sf_payments')->set($data)->execute();
            return $result[0];
        }
        
        static function updateByTransactionID($transaction_id, $data){
            DB::update('sf_payments')->set($data)->where('transaction_id', '=', $transaction_id)->limit(1)->execute();
        }
        
    }