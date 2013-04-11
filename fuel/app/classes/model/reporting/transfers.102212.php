<?php

    class Model_Reporting_Transfers extends Model{
        
        static function findSummaryByUser($user_group, DateTime $start_date, DateTime $end_date){
            
            if($user_group == 'agent'){
                
                $query = DB::select(array(db::expr("CONCAT(u.first_name,' ',u.last_name)"),'name'), array(db::expr('count(la.id)'), 'total'))
                    ->from(array('log_actions', 'la'))
                    ->join(array('actions', 'a'))->on('a.id','=','la.action_id')
                    ->join(array('users','u'))->on('u.id','=','la.user_id')
                    ->where('ts', 'between', array($start_date->format('Y-m-d'), $end_date->format('Y-m-d')))
                    ->where('la.action_id','=',ACTION_TRANSFERED)
                    ->group_by('la.user_id');
                
            }elseif($user_group == 'rep'){
                
                $query = DB::select(array(db::expr("CONCAT(su.first_name,' ',su.last_name)"),'name'),array(db::expr('count(la.id)'), 'total'))
                    ->from(array('log_actions', 'la'))
                    ->join(array('actions', 'a'))->on('a.id','=','la.action_id')
                    ->join(array('cases','c'))->on('c.id','=','la.case_id')
                    ->join(array('users', 'su'), 'LEFT')->on('su.id','=','c.sales_rep_id')
                    ->where('ts', 'between', array($start_date->format('Y-m-d'), $end_date->format('Y-m-d')))
                    ->where('la.action_id','=',ACTION_TRANSFERED)
                    ->group_by('la.user_id');  
                
            }
            /*    
            if($group_type == 'day'){
                $query->select(array(db::expr('date(la.ts)'), 'date'))->group_by(db::expr('day(la.ts)'));
            }elseif($group_type == 'week'){
                $query->group_by(db::expr('week(la.ts)'));
            }elseif($group_type == 'month'){
                $query->group_by(db::expr('year(la.ts)'));
            }
              */  
            $result = $query->execute();
            
            return $result->as_array();
        }
        
        static function findSummaryByCampaign(DateTime $start_date, DateTime $end_date){
                
            $query = DB::select('cp.name', array(db::expr('count(la.id)'), 'total'))
                ->from(array('log_actions', 'la'))
                ->join(array('actions', 'a'))->on('a.id','=','la.action_id')
                ->join(array('cases','c'))->on('c.id','=','la.case_id')
                ->join(array('campaigns','cp'))->on('cp.id','=','c.campaign_id')
                ->where('ts', 'between', array($start_date->format('Y-m-d'), $end_date->format('Y-m-d')))
                ->where('la.action_id','=',ACTION_TRANSFERED)
                ->group_by('c.campaign_id');

            $result = $query->execute();
            
            return $result->as_array();
        }
        
    }