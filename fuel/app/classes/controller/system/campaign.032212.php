<?php

    class Controller_System_Campaign extends Controller_System_Base{
        
        function action_listing(){
            
            $data['campaigns'] = Model_System_Campaign::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/campaign/listing', 'c' => $data));
            
        }
                
        function action_add(){
            
            $val = Model_System_Event::validate('add_campaign');
            
            if($val->run()){
                
                try{
                    Model_System_Event::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/campaign/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }

            $data = array();
            $this->response->body = View::factory('layout', array('l' => 'system/campaign/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_Event::validate('add_campaign');
            
            if($val->run()){
                
                try{
                    Model_System_Event::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/campaign/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['row'] = Model_System_Campaign::find($id);
            $this->response->body = View::factory('layout', array('l' => 'system/campaign/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_Event::delete($id);
                Notify::success('Campaign deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/campaign/listing');
        }
        
    }