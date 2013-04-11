<?php

    class Controller_System_Email extends Controller_System_Base{
        
        function action_listing(){
            
            $data['messages'] = Model_System_Email::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/email/listing', 'c' => $data));
            
        }
                
        function action_add(){
            
            $val = Model_System_Email::validate('add_email_template');
            
            if($val->run()){
                
                try{
                    Model_System_Email::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/email/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }

            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/email/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_Email::validate('add_email_template');
            
            if($val->run()){
                
                try{
                    Model_System_Email::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/email/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['row'] = Model_System_Email::find($id);
            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/email/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_Email::delete($id);
                Notify::success('Email message template deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/email/listing');
        }
    }