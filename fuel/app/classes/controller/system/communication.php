<?php

    class Controller_System_Communication extends Controller_System_Base{
       
        function action_listing(){
            
            $data['communications'] = Model_System_Communication::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/communication/listing', 'c' => $data));
            
        }
        
        function action_add(){
            
            $val = Model_System_Communication::validate('add_communication');
            
            if($val->run()){
                
                try{
                    Model_System_Communication::add($_POST);
                    Notify::success($_POST['name'].' Added');
                    Response::redirect('/system/communication/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['sms_messages'] = Model_System_SMS::findAll();
            $data['emails'] = Model_System_Email::findAll();
            $data['calls'] = Model_System_Call::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/communication/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_Communication::validate('update_communication');
            
            if($val->run()){
                
                try{
                    Model_System_Communication::update($id, $_POST);
                    Notify::success($_POST['name'].' Updated');
                    Response::redirect('/system/communication/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['row'] = Model_System_Communication::find($id);
            $data['sms_messages'] = Model_System_SMS::findAll();
            $data['emails'] = Model_System_Email::findAll();
            $data['calls'] = Model_System_Call::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/communication/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_Communication::delete($id);
                Notify::success('Communication deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/communication/listing');
        }
        
    }    