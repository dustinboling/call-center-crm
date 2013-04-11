<?php

    class Controller_System_Status extends Controller_System_Base{
        
        function action_listing($group_id = null){
            
            if(empty($group_id)){
                Response::redirect('/system/status/group/');
            }
            
            $data['group'] = Model_System_Status::findGroup($group_id);
            $data['statuses'] = Model_System_Status::findAll($group_id);
            $this->response->body = View::factory('layout', array('l' => 'system/status/listing', 'c' => $data));
            
        }
        
        function action_group(){
            
            $data['groups'] = Model_System_Status::findAllGroups();
            $this->response->body = View::factory('layout', array('l' => 'system/status/group', 'c' => $data));
            
        }
                
        function action_add($group_id){
            
            $val = Model_System_Status::validate('add_status');
            
            if($val->run()){
                
                try{
                    Model_System_Status::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/status/listing/'.$group_id);
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['milestones'] = Model_System_Milestone::findAll();
            $data['actions'] = Model_System_Action::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/status/form', 'c' => $data));
            
        }
        
        function action_update($group_id, $id){
            
            $val = Model_System_Status::validate('add_status');
            
            if($val->run()){
                
                try{
                    Model_System_Status::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/status/listing/'.$group_id);
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['milestones'] = Model_System_Milestone::findAll();
            $data['actions'] = Model_System_Action::findAll();
            $data['row'] = Model_System_Status::find($id);
            $data['row']['action_ids'] = Model_System_status::getActions($id);
            $this->response->body = View::factory('layout', array('l' => 'system/status/form', 'c' => $data));
            
        }
        
        function action_delete($group_id, $id){
            try{
                Model_System_Status::delete($id);
                Notify::success('Status deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/status/listing/'.$group_id);
        }
        
        function action_resort($id, $new_position){
            Model_System_Status::resort($id, $new_position);
        }
        
        function action_listing_json($group_id = 1){
            $statuses = Model_System_Status::findAll($group_id);
            print json_encode($statuses);
        }
    }