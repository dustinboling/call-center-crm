<?php
 
    namespace CallTracking;
   
    class Controller_Dashboard extends Controller_Base{
        
        function action_index(){
            
            $data['calls'] = Model_Reporting::getCallsSummary(date('Y-m-d'), date('Y-m-d', strtotime('+1 day')));
            $this->response->body = \View::factory('layout', array('l' => 'dashboard/index', 'c' => $data));
            
        }
        
    }