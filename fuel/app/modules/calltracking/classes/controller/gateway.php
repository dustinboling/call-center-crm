<?php

    namespace CallTracking;

    class Controller_Gateway extends \Controller{
        
        function action_voice(){
            
            \DB::insert('ct_incoming_posts')->set(array('data' => serialize($_POST)))->execute();

            $forwarding_number = Model_Campaign::findForwardingNumber($_POST['Called']);

            $response = simplexml_load_string('<Response/>');
            $dial = $response->addChild('Dial', '+1'.$forwarding_number);
            $dial->addAttribute('action', '/calltracking/gateway/save_voice');
            $dial->addAttribute('method', 'POST');
            $dial->addAttribute('record', true);
            
            print $response->asXML();
            
        }
        
        function action_save_voice(){

            Model_Call::save($_POST);
            print '<Response/>';
            
        }
        
    }