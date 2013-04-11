<?php

    class Controller_Reporting_Dashboard extends Controller_Base{
        
        function action_index(){
            $this->response->body = View::factory('layout', array('l' => 'reporting/dashboard/index', 'c' => array()));
        }
        
    }