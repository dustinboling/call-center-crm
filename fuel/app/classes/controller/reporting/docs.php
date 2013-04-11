<?php

    class Controller_Reporting_Docs extends Controller_Base{
        
        function before(){
            parent::before();
            if(Model_Account::getType() == 'User'){
                Response::redirect('/reporting/dashboard');
            }
        }
        
        function action_in($range = null){
            
            if($range == 'custom'){
                $start = new DateTime($_POST['start']);
                $end = new DateTime($_POST['end']);
                $end->modify('+1 day')->modify('-1 second');
            }elseif(!empty($range)){
                list($start, $end) = DateRange::get($range);
            }else{
                list($start, $end) = DateRange::today();
            }
            
            $data['docs'] = Model_Reporting_Docs::findSummaryIn($start, $end);
            
            $this->response->body = View::factory('layout', array('l' => 'reporting/docs/in', 'c' => $data));
            
        }
        
        function action_out($range = null){
            
            if($range == 'custom'){
                $start = new DateTime($_POST['start']);
                $end = new DateTime($_POST['end']);
                $end->modify('+1 day')->modify('-1 second');
            }elseif(!empty($range)){
                list($start, $end) = DateRange::get($range);
            }else{
                list($start, $end) = DateRange::today();
            }
            
            $data['docs'] = Model_Reporting_Docs::findSummaryOut($start, $end);
            
            $this->response->body = View::factory('layout', array('l' => 'reporting/docs/out', 'c' => $data));
            
        }
        
    }