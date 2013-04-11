<?php

    class Model_BatchDistribution extends Model{
        
        static protected $loaded;
        static protected $reps;
        static protected $log;
        
        static function getNextRepCampaign($campaign_id){
            
            if(empty(self::$reps[$campaign_id]) && !empty(self::$loaded[$campaign_id])){
                return null;
            }elseif(empty(self::$reps[$campaign_id])){
                self::$reps[$campaign_id] = Model_Distribution::getDistributionListCampaign($campaign_id);
                self::$loaded[$campaign_id] = 1;
            }
            
            $rep = next(self::$reps[$campaign_id]);
            
            if($rep !== false){
                return $rep;
            }
            
            $rep = reset(self::$reps[$campaign_id]);
            
            return $rep;
            
        }
        
        static function getNextRepGroup($group_id){
            
            if(empty(self::$reps[$group_id]) && !empty(self::$loaded[$group_id])){
                return null;
            }elseif(empty(self::$reps[$group_id])){
                self::$reps[$group_id] = Model_Distribution::getDistributionListGroup($group_id);
                self::$loaded[$group_id] = 1;
            }
            
            $rep = next(self::$reps[$group_id]);
            
            if($rep !== false){
                return $rep;
            }
            
            $rep = reset(self::$reps[$group_id]);
            
            return $rep;
            
        }
        
        static function logDistribution($rep_id, $case_id){
            self::$log[$rep_id] = array('rep_id' => $rep_id, 'case_id' => $case_id);
        }
        
        static function saveLog(){
            
            if(!empty(self::$log)){
                foreach(self::$log as $l){
                    Model_Distribution::logDistributedCase($l['rep_id'], $l['case_id']);
                }
            }
            
        }
        
    }