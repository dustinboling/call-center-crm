<?php

    class Model_Reporting_Commissions extends Model{
        
        static function findByDateRange($start_date, $end_date, $rep_id = null){
            
            $query = DB::select(array('case_id', 'id'),
                                DB::expr("count(id) as payments_made_count"), 
                                DB::expr("sum(amount) as amount"), 
                                DB::expr("MAX(created) as last_payment"), 
                                DB::expr("sum(commission) as commissions"))
                        ->from("sf_payments")
                        ->where("created", 'BETWEEN', array($start_date->format('Y-m-d'), $end_date->format('Y-m-d'). ' 23:59:59'))
                        ->where('status', '=', 'Processed')
                        ->group_by('case_id');
            
            if(Model_Account::getType() == 'User'){
                $query->where('sales_rep_id', '=', $_SESSION['user']['id']);
            }else if(!empty($rep_id)){
                $query->where('sales_rep_id', '=', $rep_id);
            }
            
            $result = $query->execute();
          
            $merged = Model_Case::buildResult($result, array('id','first_name', 'last_name', 'total_fees'));
            
//            print '<pre>';
//            print_r($result->as_array());exit;
            
            return $merged;            
            
        }
        
        static function findByCaseID($case_id){
            
            $query = DB::select()->from('sf_payments')->where('case_id', '=', $case_id)->order_by('sort');
            
            $result = $query->execute();
            
            return $result;
            
        }
        
    }