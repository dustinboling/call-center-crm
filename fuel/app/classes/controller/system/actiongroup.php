<?php

    class Controller_System_ActionGroup extends Controller_System_Base{
        
        function action_listing(){
            
            $data['groups'] = Model_System_ActionGroup::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/actiongroup/listing', 'c' => $data));
            
        }
        
        function action_add(){
            
            $val = Model_System_ActionGroup::validate('add_actiongroup');
            
            if($val->run()){
                
                try{
                    Model_System_ActionGroup::add($_POST);
                    Notify::success($_POST['name'].' Added');
                    Response::redirect('/system/actiongroup/listing/');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
        
            $data = array();
            $this->response->body = View::factory('layout', array('l' => 'system/actiongroup/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_ActionGroup::validate('add_actiongroup');
            
            if($val->run()){
                
                try{
                    Model_System_ActionGroup::update($id, $_POST);
                    Notify::success($_POST['name'].' Updated');
                    Response::redirect('/system/actiongroup/listing/');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }

            $data['row'] = Model_System_ActionGroup::find($id);
            $this->response->body = View::factory('layout', array('l' => 'system/actiongroup/form', 'c' => $data));
            
        }
        
        function action_delete($action_id, $id){
            try{
                Model_System_ActionGroup::delete($id);
                Notify::success('Group Deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/actiongroup/listing/'.$action_id);
        }
    }