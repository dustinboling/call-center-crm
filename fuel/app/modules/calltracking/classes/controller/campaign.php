<?php

    namespace CallTracking;

    class Controller_Campaign extends Controller_Base{
        
        function action_listing(){
            
            $data['filter_bar'] = \View::factory('call/filter_bar', array('campaigns' => Model_Campaign::findAll(0, 500)), false)->render();
            $data['campaigns'] = Model_Campaign::findAll($this->offset, $this->limit);
            $this->response->body = \View::factory('layout', array('l' => 'campaign/listing', 'c' => $data));
            
        }
        
        function action_calls($campaign_id){
            $data['campaign'] = Model_Campaign::find($campaign_id);
            $data['dispositions'] = Model_Disposition::findAll();
            $data['filter_bar'] = \View::factory('call/filter_bar', array('campaigns' => Model_Campaign::findAll(0, 500)), false)->render();
            $data['calls'] = Model_Call::findByCampaign($campaign_id, $this->offset, $this->limit);
            $data['pagination'] = array('limit' => $this->limit, 'total_items' => Model_Call::countByCampaign($campaign_id));
            $this->response->body = \View::factory('layout', array('l' => 'campaign/calls', 'c' => $data));
        }
        
        function action_add(){
            
            $val = Model_Campaign::validate('add_campaign');
            
            if($val->run()){
                
                Model_Campaign::add($_POST);
                \Notify::success($_POST['name'] . ' Added');
                \Response::redirect('/calltracking/campaign/listing');
                
            }else{
                $errors = $val->show_errors();
                if(!empty($errors)){
                    \Notify::setFlash((string)$val->show_errors(),'error','block');
                }
            }
            
            $data['internal_numbers'] = Model_Number::findByType('internal');
            $data['purchased_numbers'] = Model_Number::findByType('purchased', 1);

            if(count($data['purchased_numbers']) == 0){
                \Notify::alert("You don't have any available Purchased Numbers, select another one before adding a campaign.");
                \Response::redirect('/calltracking/number/purchase');
            }
            
            $data['subaccounts'] = Model_Subaccount::findAll();
            
            $this->response->body = \View::factory('layout', array('l' => 'campaign/add', 'c' => $data));
            
        }
        
        function action_update($id){
            
             $val = Model_Campaign::validate('update_campaign');
            
            if($val->run()){

                Model_Campaign::update($id, $_POST);
                \Notify::success($_POST['name'] . ' Updated');
                \Response::redirect('/calltracking/campaign/listing');
                
            }else{
                $errors = $val->show_errors();
                if(!empty($errors)){
                    \Notify::setFlash((string)$val->show_errors(),'error','block');
                }
            }
            
            $data['internal_numbers'] = Model_Number::findByType('internal');
            $data['purchased_numbers'] = Model_Number::findByType('purchased');
            
            $data['subaccounts'] = Model_Subaccount::findAll();
            
            $campaign = Model_Campaign::find($id);
            
            if($campaign['after_hours_forwarding']){
                
                $ahf_start = strtotime($campaign['after_hours_start']);
                $campaign['ahf_start_hour'] = (date('h', $ahf_start)<=12?date('h', $ahf_start):sprintf('%02d',date('h', $ahf_start)-12));
                $campaign['ahf_start_minute'] = date('i', $ahf_start);
                $campaign['ahf_start_meridiem'] = date('a', $ahf_start);
                
                $ahf_end = strtotime($campaign['after_hours_end']);
                $campaign['ahf_end_hour'] = (date('h', $ahf_end)<=12?date('h', $ahf_end):sprintf('%02d',date('h', $ahf_end)-12));
                $campaign['ahf_end_minute'] = date('i', $ahf_end);
                $campaign['ahf_end_meridiem'] = date('a', $ahf_end);
            }
            
            $data['campaign'] = $campaign;
            
            $this->response->body = \View::factory('layout', array('l' => 'campaign/update', 'c' => $data));
            
        }
        
        function action_delete($id){
            
            Model_Campaign::delete($id);
            \Response::redirect('/calltracking/campaign/listing');
            
        }
        
    }