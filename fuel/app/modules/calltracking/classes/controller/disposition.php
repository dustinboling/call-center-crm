<?php

    namespace CallTracking;

    class Controller_Disposition extends Controller_Base{
        
        function action_index(){
            
        }
        
        function action_listing(){
            
            $data['dispositions'] = Model_Disposition::findAll();
            $this->response->body = \View::factory('layout', array('l' => 'disposition/listing', 'c' => $data));
            
        }
        
        function action_add(){
            
            print Model_Disposition::add($_POST);
            
        }
        
        function action_update($id){
            
            Model_Disposition::update($id, $_POST);
            
        }
        
        function action_delete($id){
            
            Model_Disposition::delete($id);
            
        }
        
    }