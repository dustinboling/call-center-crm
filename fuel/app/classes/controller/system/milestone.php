<?php

    class Controller_System_Milestone extends Controller_System_Base{
        
        function action_listing(){
            
            $data['milestones'] = Model_System_Milestone::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/milestone/listing', 'c' => $data));
            
        }
                
        function action_add(){
            
            $val = Model_System_Milestone::validate('add_milestone');
            
            if($val->run()){
                
                try{
                    Model_System_Milestone::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/milestone/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }

            $data['fields'] = Model_System_Milestone::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/milestone/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_Milestone::validate('add_milestone');
            
            if($val->run()){
                
                try{
                    Model_System_Milestone::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/milestone/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['row'] = Model_System_Milestone::find($id);
            $this->response->body = View::factory('layout', array('l' => 'system/milestone/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_Milestone::delete($id);
                Notify::success('Milestone deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/milestone/listing');
        }
    }