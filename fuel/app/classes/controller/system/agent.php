<?php

    class Controller_System_Agent extends Controller_System_Base{
       
        function action_listing(){
            
            $data['agents'] = Model_System_Agent::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/agent/listing', 'c' => $data));
            
        }
        
                
        function action_add(){
            
            $val = Model_System_Agent::validate('add_agent');
            
            if($val->run()){
                
                try{
                    Model_System_Agent::add($_POST);
                    Notify::success($_POST['first_name'].' '.$_POST['last_name'].' Added');
                    Response::redirect('/system/agent/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data = array();
            $this->response->body = View::factory('layout', array('l' => 'system/agent/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_Agent::validate('update_agent');
            
            if($val->run()){
                
                try{
                    Model_System_Agent::update($id, $_POST);
                    Notify::success($_POST['first_name'].' '.$_POST['last_name'].' Updated');
                    Response::redirect('/system/agent/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['row'] = Model_System_Agent::find($id);
            $this->response->body = View::factory('layout', array('l' => 'system/agent/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_Agent::delete($id);
                Notify::success('Agent deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/agent/listing');
        }
        
    }    