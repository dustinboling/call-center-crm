<?php
    
    class Controller_Dashboard extends Controller_Base{
        
        function action_index(){
            
            Response::redirect('/case/listing');
            
            $data = array();
            $this->response->body = View::factory('layout', array('l' => 'dashboard/index', 'c' => $data));
            
        }
        
    }