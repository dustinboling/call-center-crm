<?php

    class Controller_System_Call extends Controller_System_Base{
        
        function action_listing(){
            
            $data['messages'] = Model_System_Call::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/call/listing', 'c' => $data));
            
        }
                
        function action_add(){
            
            $val = Model_System_Call::validate('add_call_template');
            
            if($val->run()){
                
                try{
                    Model_System_Call::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/call/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            Fuel::add_module('calltracking');
            
            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/call/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_Call::validate('add_call_template');
            
            if($val->run()){
                
                try{
                    Model_System_Call::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/call/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            Fuel::add_module('calltracking');
            
            $data['row'] = Model_System_Call::find($id);
            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/call/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_Call::delete($id);
                Notify::success('Call template deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/call/listing');
        }
    }