<?php

    class Controller_System_ActionTask extends Controller_System_Base{
        
        function action_targets($task_id){
            
            $targets = Model_System_ActionTask::findTargets($task_id);
            print json_encode($targets);
            
        }
        
        function action_listing($action_id){
            
            $data['action'] = Model_System_Action::find($action_id);
            $data['tasks'] = Model_System_ActionTask::findByActionID($action_id);
            $this->response->body = View::factory('layout', array('l' => 'system/actiontask/listing', 'c' => $data));
            
        }
        
        function action_add($action_id){
            
            $val = Model_System_ActionTask::validate('add_actiontask');
            
            if($val->run()){
                
                try{
                    Model_System_ActionTask::add($_POST);
                    Notify::success('Task Added');
                    Response::redirect('/system/actiontask/listing/'.$action_id);
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
        
            $data['action'] = Model_System_Action::find($action_id);
            $data['tasks'] = Model_System_ActionTask::findTypes();
            $this->response->body = View::factory('layout', array('l' => 'system/actiontask/form', 'c' => $data));
            
        }
        
        function action_update($action_id, $id){
            
            $val = Model_System_ActionTask::validate('add_actiontask');
            
            if($val->run()){
                
                try{
                    Model_System_ActionTask::update($id, $_POST);
                    Notify::success('Task Updated');
                    Response::redirect('/system/actiontask/listing/'.$action_id);
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['action'] = Model_System_Action::find($action_id);
            $data['tasks'] = Model_System_ActionTask::findTypes();
            $data['row'] = Model_System_ActionTask::find($id);
            $this->response->body = View::factory('layout', array('l' => 'system/actiontask/form', 'c' => $data));
            
        }
        
        function action_delete($action_id, $id){
            try{
                Model_System_ActionTask::delete($id);
                Notify::success('Task Deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/actiontask/listing/'.$action_id);
        }
    }