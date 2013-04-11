<?php

    namespace CallTracking;

    class Controller_Call extends Controller_Base{
        
        function action_set_disposition($call_id, $disposition_id){
            
            Model_Call::set_disposition($call_id, $disposition_id);
            
        }
        
        function action_by_date($start_date, $end_date = null){
            
            $start_date = date('Y-m-d', strtotime($start_date));
            
            if(!empty($end_date)){
                $end_date = date('Y-m-d', strtotime($end_date));
            }else{
                $end_date = date('Y-m-d', strtotime('+1 day', strtotime($start_date)));
            }
            
            $data['filter_bar'] = \View::factory('call/filter_bar', array('campaigns' => Model_Campaign::findAll(0, 500)), false)->render();
            $data['dispositions'] = Model_Disposition::findAll();
            $data['calls'] = Model_Call::findByDate($start_date, $end_date, $this->offset, $this->limit);
            $data['pagination'] = array('limit' => $this->limit, 'total_items' => Model_Call::countByDate($start_date, $end_date));
            $this->response->body = \View::factory('layout', array('l' => 'call/listing', 'c' => $data));
            
        }
        
        function action_by_filter(){

            $campaign_id = null;
            if(isset($_GET['campaign_id']) && !empty($_GET['campaign_id'])){
                $campaign_id = $_GET['campaign_id'];
            }

            $start_date = null;
            if(isset($_GET['start_date']) && !empty($_GET['start_date'])){
                $start_date = date('Y-m-d', strtotime($_GET['start_date']));
            }

            $end_date = null;
            if(isset($_GET['end_date']) && !empty($_GET['end_date'])){
                $end_date = date('Y-m-d', strtotime($_GET['end_date']));
                $end_date .= ' 11:59:59';
            }
                
            if(empty($campaign_id) && (empty($start_date) || empty($end_date))){
                \Notify::error('You must specify a campaign or a date range to find calls');
                \Response::redirect('calltracking/campaign/listing');
            }
            
            $data['campaign'] = array();
            if(!empty($campaign_id)){
                $data['campaign'] = Model_Campaign::find($campaign_id);
            }
            
            $data['filter_bar'] = \View::factory('call/filter_bar', array('campaigns' => Model_Campaign::findAll(0, 500)), false)->render();
            $data['dispositions'] = Model_Disposition::findAll();
            $data['calls'] = Model_Call::findByFilter($campaign_id, $start_date, $end_date, $this->offset, $this->limit);
            $data['pagination'] = array('limit' => $this->limit, 'total_items' => Model_Call::countByFilter($campaign_id, $start_date, $end_date));
            
            if(isset($_GET['export'])){
                $data['calls'] = Model_Call::findByFilter($campaign_id, $start_date, $end_date, 0, 10000);
                $data['notes'] = Model_Note::getNotesExport($data['calls']);
                $this->response->body = \View::factory('call/export', $data);
            }else{
                $data['calls'] = Model_Call::findByFilter($campaign_id, $start_date, $end_date, $this->offset, $this->limit);
                $data['pagination'] = array('limit' => $this->limit, 'total_items' => Model_Call::countByFilter($campaign_id, $start_date, $end_date));
                $this->response->body = \View::factory('layout', array('l' => 'call/filtered', 'c' => $data));
            }
            
        }
        
        function action_recording($call_id){
            $data['call'] = Model_Call::find($call_id);
            $this->response->body = \View::factory('empty', array('l' => 'call/recording', 'c' => $data));
        }
        
    }