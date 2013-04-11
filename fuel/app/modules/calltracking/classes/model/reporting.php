<?php

    namespace CallTracking;

    class Model_Reporting extends \Model{
        
        static function getCallsSummary($start_date = null, $end_date = null){
            
            $query = \DB::select(\DB::expr('count(id) as calls'),
                                 \DB::expr('max(duration) as max_minutes'),
                                 \DB::expr('avg(duration) as average_minutes'), 
                                 \DB::expr('sum(duration) as total_minutes'))
                        ->from('ct_calls')
                        ->where('org_id', '=', $_SESSION['user']['org_id']);
            
            if(!empty($start_date) && !empty($end_date)){
                $query->where('start_time', '>=', $start_date)
                       ->where('start_time', '<=', $end_date);
            }
            
            $result = $query->execute();
            
            return current($result->as_array());
                        
            
        }
        
    }