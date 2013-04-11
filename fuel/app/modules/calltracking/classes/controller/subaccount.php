<?php

    namespace CallTracking;

    class Controller_Subaccount extends Controller_Base{
        
        function action_index(){
            
        }
        
        function action_listing(){
            
            $data['subaccounts'] = Model_Subaccount::findAll();
            $this->response->body = \View::factory('layout', array('l' => 'subaccount/listing', 'c' => $data));

        }
        
        function action_add(){
            
            if($_POST){
                
                Model_Subaccount::add($_POST);
                \Notify::success($_POST['company'] . ' Added');
                \Response::redirect('/calltracking/subaccount/listing');
                
            }
            
            $data = array();
            $this->response->body = \View::factory('layout', array('l' => 'subaccount/add', 'c' => $data));

        }
        
        function action_update($id){
            
            if($_POST){
                
                Model_Subaccount::update($id, $_POST);
                \Notify::success($_POST['company'] . ' Updated');
                \Response::redirect('/calltracking/subaccount/listing');
                
            }
            
            $data['subaccount'] = Model_Subaccount::find($id);
            $this->response->body = \View::factory('layout', array('l' => 'subaccount/update', 'c' => $data));
            
        }
        
        function action_delete($id){
            
            Model_Subaccount::delete($id);
            
        }
        
    }