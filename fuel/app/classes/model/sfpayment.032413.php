<?php

    class Model_SFPayment extends Model{
        
        static function findByCase($case_id){
            
            $result = DB::select()->from('sf_payments')->where('case_id','=',$case_id)->execute();
            return $result->as_array();
            
        }
        
    }