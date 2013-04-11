<?php

    class Model_Distribution extends Model{
        
        static function getNextDistributionRep($campaign_id){
            
            $result = self::getDistributionListCampaign($campaign_id, 1);
            return current($result);
            
        }
        
        static function getDistributionListCampaign($campaign_id, $limit = 0){
            
            $query = DB::select(array('u.id', 'sales_rep_id'), array(DB::expr("CONCAT(u.first_name,' ',u.last_name)"), 'sales_rep_name'))
                    ->from(array('distribution_groups_campaigns', 'dgc'))
                    ->join(array('distribution_users_groups', 'dug'))->on('dug.group_id', '=', 'dgc.group_id')
                    ->join(array('users', 'u'))->on('dug.user_id', '=', 'u.id')
                    ->where('dgc.campaign_id', '=', $campaign_id)
                    ->order_by('dug.last_case');

            if(!empty($limit)){
                $query->limit($limit);
            }
            
            $result = $query->execute();
            
            if(!count($result)){
                return null;
            }
            
            return $result->as_array();
            
        }
        
        static function getDistributionListGroup($group_id, $limit = 0){
            
            $query = DB::select(array('u.id', 'sales_rep_id'), array(DB::expr("CONCAT(u.first_name,' ',u.last_name)"), 'sales_rep_name'))
                    ->from(array('distribution_users_groups', 'dug'))
                    ->join(array('users', 'u'))->on('dug.user_id', '=', 'u.id')
                    ->where('dug.group_id', '=', $group_id)
                    ->order_by('dug.last_case');

            if(!empty($limit)){
                $query->limit($limit);
            }
            
            $result = $query->execute();
            
            if(!count($result)){
                return null;
            }
            
            return $result->as_array();
            
        }
        
        static function logDistributedCase($rep_id, $case_id){
            
            DB::update('distribution_users_groups')
                    ->set(array('last_case' => DB::expr('now()'), 'case_id' => $case_id))
                    ->where('user_id', '=', $rep_id)
                    ->execute();
            
        }
        
    }