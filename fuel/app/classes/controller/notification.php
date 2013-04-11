<?php

    class Controller_Notification extends Controller{
        
        function action_call($app_id, $call_id){
            
            $fields = Model_System_TemplateFields::load($app_id);
            $call = Model_System_Call::find($call_id);
            
            $call = Model_System_templateFields::parseTemplate($call, $fields);
            
            $response = simplexml_load_string('<Response/>');
            $say = $response->addChild('Say', $call['message']);
            $say->addAttribute('voice', 'woman');
            $hangup = $response->addChild('Hangup');
            
            print $response->asXML();
            
        }
        
    }