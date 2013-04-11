<?php

    class Controller_Reporting_Transfers extends Controller_Base{
        
        function action_user($range = null){
            
            if($range == 'custom'){
                $start = new DateTime($_POST['start']);
                $end = new DateTime($_POST['end']);
                $end->modify('+1 day')->modify('-1 second');
            }elseif(!empty($range)){
                list($start, $end) = DateRange::get($range);
            }else{
                list($start, $end) = DateRange::today();
            }
            
            $data['agents'] = Model_Reporting_Transfers::findSummaryByUser('agent', $start, $end);
            $data['reps'] = Model_Reporting_Transfers::findSummaryByUser('rep', $start, $end);
            
            $this->response->body = View::factory('layout', array('l' => 'reporting/transfers/user', 'c' => $data));
            
        }
        
        function action_campaign($range = null){
            
            if($range == 'custom'){
                $start = new DateTime($_POST['start']);
                $end = new DateTime($_POST['end']);
                $end->modify('+1 day')->modify('-1 second');
            }elseif(!empty($range)){
                list($start, $end) = DateRange::get($range);
            }else{
                list($start, $end) = DateRange::today();
            }
            
            $data['campaigns'] = Model_Reporting_Transfers::findSummaryByCampaign($start, $end);
            
            $this->response->body = View::factory('layout', array('l' => 'reporting/transfers/campaign', 'c' => $data));
            
        }
        
    }