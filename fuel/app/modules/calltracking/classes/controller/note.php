<?php

    namespace CallTracking;

    class Controller_Note extends Controller_Base{
        
        function action_call($call_id){
            
            $data['notes'] = Model_Note::findByCallID($call_id);
            $this->response->body = \View::factory('empty', array('l' => 'note/view', 'c' => $data));
            
        }
        
        function action_add(){

            print json_encode(Model_Note::add($_POST));
            
        }
        
        function action_update($id){
            
            Model_Note::update($id, $_POST);
            
        }
        
        function action_delete($id){
            
            Model_Note::delete($id);
            
        }
        
    }