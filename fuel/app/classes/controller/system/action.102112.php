<?php

    class Controller_System_Action extends Controller_System_Base{
       
        function action_listing(){
            
            $data['actions'] = Model_System_Action::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/action/listing', 'c' => $data));
            
        }
                
        function action_add(){
            
            $val = Model_System_Action::validate('add_action');
            
            if($val->run()){
                
                try{
                    Model_System_Action::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/action/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data = array();
            $this->response->body = View::factory('layout', array('l' => 'system/action/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_Action::validate('add_action');
            
            if($val->run()){
                
                try{
                    Model_System_Action::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/action/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['row'] = Model_System_Action::find($id);
            $this->response->body = View::factory('layout', array('l' => 'system/action/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_Action::delete($id);
                Notify::success('Action template deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/action/listing');
        }
        
    }