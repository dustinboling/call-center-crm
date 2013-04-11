<?php

    class Controller_System_Campaign extends Controller_System_Base{
        
        function action_listing(){
            
            $data['campaigns'] = Model_System_Campaign::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/campaign/listing', 'c' => $data));
            
        }
                
        function action_add(){
            
            $val = Model_System_Campaign::validate('add_campaign');
            
            if($val->run()){
                
                try{
                    Model_System_Campaign::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/campaign/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }

            $data['distribution_groups'] = Model_System_DistributionGroup::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/campaign/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_Campaign::validate('add_campaign');
            
            if($val->run()){
                
                try{
                    Model_System_Campaign::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/campaign/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['row'] = Model_System_Campaign::find($id);
            $data['distribution_groups'] = Model_System_DistributionGroup::findAll();
            $groups = Model_System_DistributionCampaign::findByCampaign($id);
            
            foreach($groups as $g){
                $data['row']['groups'][] = $g['group_id'];
            }
            
            $this->response->body = View::factory('layout', array('l' => 'system/campaign/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_Campaign::delete($id);
                Notify::success('Campaign deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/campaign/listing');
        }
        
    }