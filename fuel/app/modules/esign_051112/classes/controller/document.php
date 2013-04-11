<?php

    namespace ESign;

    class Controller_Document extends Controller_Base{
        
        function action_application($app_id){
            
            $data['forms'] = Model_Form::findESign();
            $data['documents'] = Model_Document::findByAppID($app_id);
            $data['tabs']['customer'] = '';
            $this->response->body = \View::factory('layout', array('l' => 'document/application', 'c' => $data));
            
        }
        
        function action_send($app_id, $document_id){
            $data = array();
            $data['tabs']['customer'] = '';
            $this->response->body = \View::factory('layout', array('l' => 'document/send', 'c' => $data));
        }
        
    }