<?php

    class Controller_System_Event extends Controller_System_Base{
        
        function action_listing(){
            
            $data['events'] = Model_System_Event::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/event/listing', 'c' => $data));
            
        }
                
        function action_add(){
            
            $val = Model_System_Event::validate('add_event_template');
            
            if($val->run()){
                
                try{
                    Model_System_Event::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/event/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/event/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_Event::validate('add_event_template');
            
            if($val->run()){
                
                try{
                    Model_System_Event::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/event/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['row'] = Model_System_Event::find($id);
            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/event/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_Event::delete($id);
                Notify::success('Event template deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/event/listing');
        }
        
    }