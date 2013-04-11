<?php

    class Controller_System_Sms extends Controller_System_Base{
        
        function action_listing(){
            
            $data['messages'] = Model_System_SMS::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/sms/listing', 'c' => $data));
            
        }
                
        function action_add(){
            
            $val = Model_System_SMS::validate('add_sms_template');
            
            if($val->run()){
                
                try{
                    Model_System_SMS::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/sms/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            Fuel::add_module('calltracking');
            
            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/sms/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_SMS::validate('add_sms_template');
            
            if($val->run()){
                
                try{
                    Model_System_SMS::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/sms/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            Fuel::add_module('calltracking');
            
            $data['row'] = Model_System_SMS::find($id);
            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/sms/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_SMS::delete($id);
                Notify::success('SMS message template deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/sms/listing');
        }
    }