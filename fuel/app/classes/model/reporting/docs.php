<?php

    class Model_Reporting_Docs extends Model{
        
        static function findSummaryIn($start, $end){
            
            $action_ids = Model_System_Action::findIDsByGroup(ACTION_GROUP_DOCSIN);
            
            $result = DB::select(array('a.name', 'action'), DB::expr('count(la.case_id) as total'))
                    ->from(array('log_actions', 'la'))
                    ->join(array('actions', 'a'))->on('a.id','=','la.action_id')
                    ->where('ts', 'between', array($start->format('Y-m-d'), $end->format('Y-m-d')))
                    ->where('la.action_id', 'in', $action_ids)
                    ->group_by('la.action_id')
                    ->execute();
            
            return $result->as_array();
            
        }
        
        static function findSummaryOut($start, $end){
                        
            $action_ids = Model_System_Action::findIDsByGroup(ACTION_GROUP_DOCSOUT);
            
            $result = DB::select(array('a.name', 'action'), DB::expr('count(la.case_id) as total'))
                    ->from(array('log_actions', 'la'))
                    ->join(array('actions', 'a'))->on('a.id','=','la.action_id')
                    ->where('ts', 'between', array($start->format('Y-m-d'), $end->format('Y-m-d')))
                    ->where('la.action_id', 'in', $action_ids)
                    ->group_by('la.action_id')
                    ->execute();
            
            return $result->as_array();
        }
        
    }