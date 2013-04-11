<?php

    class Controller_Reporting_Commissions extends Controller_Base{
        
        function action_index(){
            Response::redirect('/reporting/commissions/dashboard');
        }
        
        function action_dashboard(){
            
            $data = array();
            $this->response->body = View::factory('layout', array('l' => 'reporting/commissions/dashboard', 'c' => $data));
            
        }
        
        function action_summary(){
            
            if(!empty($_POST)){
                Response::redirect('/reporting/commissions/summary/?'. http_build_query($_POST));
            }
            
            $start_date = new DateTime('-1 day');
            $end_date = new DateTime;
            if(isset($_GET['start']) && isset($_GET['end'])){
                $start_date = new DateTime($_GET['start']);
                $end_date = new DateTime($_GET['end']);
            }
            
            $sales_rep_id = null;
            if(isset($_GET['rep_id'])){
                $sales_rep_id = $_GET['rep_id'];
            }
            
            $data = array('start' => $start_date, 'end' => $end_date);
            $data['users'] = Model_System_User::findByDepartment(array('sales'));
            $data['result'] = Model_Reporting_Commissions::findByDateRange($start_date, $end_date, $sales_rep_id);
            $this->response->body = View::factory('layout', array('l' => 'reporting/commissions/summary', 'c' => $data));
            
        }      
        
        function action_detail($case_id){
            
            $data['payments'] = Model_Reporting_Commissions::findByCaseID($case_id);
            $this->response->body = View::factory('layout', array('l' => 'reporting/commissions/detail', 'c' => $data));
            
        }        
    }
