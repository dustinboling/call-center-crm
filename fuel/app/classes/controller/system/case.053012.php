<?php

    class Controller_System_Case extends Controller_System_Base{
        
        function action_export(){
            
            if(!empty($_POST)){
                ini_set('memory_limit', '256M');
                Model_Case::export($_POST);
                exit;
            }
            
            $data['statuses'] = Model_System_Status::findAll(1);
            $data['campaigns'] = Model_System_Campaign::findAll();
            $data['fgroups'] = Model_System_ObjectFields::findAllGroups();
            $data['fields'] = Model_System_ObjectFields::findAllGrouped(1);
            $this->response->body = View::factory('layout', array('l' => 'system/case/export', 'c' => $data));
            
        }
                
    }