<?php

    class Controller_System_DistributionGroup extends Controller_System_Base{
        
        function action_listing(){
            
            $data['groups'] = Model_System_DistributionGroup::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/distribution/group/listing', 'c' => $data));
            
        }
        
        function action_add(){
            
            $val = Model_System_DistributionGroup::validate('add_distributiongroup');
            
            if($val->run()){
                
                try{
                    Model_System_DistributionGroup::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/distributiongroup/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            $data['users'] = Model_System_User::findByDepartment('sales');
            $this->response->body = View::factory('layout', array('l' => 'system/distribution/group/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_DistributionGroup::validate('update_distributiongroup');
            
            if($val->run()){
                
                try{
                    Model_System_DistributionGroup::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/distributiongroup/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            
            $data['row'] = Model_System_DistributionGroup::find($id);
            $data['users'] = Model_System_User::findByDepartment('sales');
            $users = Model_System_DistributionUser::findByGroup($id);
            
            foreach($users as $u){
                $data['row']['users'][] = $u['user_id'];
            }
            
            $this->response->body = View::factory('layout', array('l' => 'system/distribution/group/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            
            try{
                Model_System_DistributionGroup::delete($id);
                Notify::success('Distribution Group deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            
            Response::redirect('/system/distributiongroup/listing');
            
        }
        
    }