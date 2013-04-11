<?php

    class Controller_Event extends Controller_Base{
        
        function action_listing(){
            
            $data['events'] = Model_Event::findByUser($_SESSION['user']['id'], $this->offset, $this->limit);
            
            $case_ids = array();
            foreach($data['events'] as $e){
                $case_ids[] = $e['case_id'];
            }
            
            $data['cases'] = Model_Case::findBaseData($case_ids);

            $data['pagination'] = array('limit' => $this->limit, 'total_items' => Model_Event::findCountByUserID($_SESSION['user']['id']));
            
            $this->response->body = View::factory('layout', array('l' => 'event/listing', 'c' => $data));
            
        }
        
        function action_by_date($start_date = null, $end_date = null){
            
            if(empty($start_date)){
                $start_date = date('Y-m-d');
            }
            
            $data['events'] = Model_Event::findByDate($start_date, $end_date);
            
            $case_ids = array();
            foreach($data['events'] as $e){
                $case_ids[] = $e['case_id'];
            }
            
            $data['cases'] = Model_Case::findBaseData($case_ids);
            
            $this->response->body = View::factory('layout', array('l' => 'event/listing', 'c' => $data));
        }
        
        function action_by_status($status){
            
            $data['events'] = Model_Event::findByStatus($status);
            
            $case_ids = array();
            foreach($data['events'] as $e){
                $case_ids[] = $e['case_id'];
            }
            
            $data['cases'] = Model_Case::findBaseData($case_ids);            
            
            $this->response->body = View::factory('layout', array('l' => 'event/listing', 'c' => $data));
        }
        
                
        function action_update($id){
            
            if(!empty($_POST)){
                
                try{
                    Model_Event::update($id, $_POST);
                    Notify::success('Appointment Updated');
                    response::redirect('event/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['event'] = Model_Event::find($id);
            
            $this->response->body = View::factory('layout', array('l' => 'event/update', 'c' => $data));
            
        }
        
        function action_delete($id){
            
            try{
                Model_Event::delete($id);
                Notify::success('Appointment Deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            
            header('location: '.$_SERVER['HTTP_REFERER']);
            exit;
            
        }
        
        function action_complete($id){
            
            try{
                Model_Event::complete($id);
                Notify::success('Appointment Marked Complete');
            }catch(Exception $e){
                Notify::error($e);
            }
            
            header('location: '.$_SERVER['HTTP_REFERER']);
            exit;
            
        }
        
        function action_popups(){
            
            $popups = Model_Event::getPopups();
            print json_encode($popups);
            
        }
        
        function action_record_popup($id){
            Model_Event::completeReminderPopup($id);
        }
        
    }