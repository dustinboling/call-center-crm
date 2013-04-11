<?php

    class Controller_System_User extends Controller_System_Base{
       
        function action_listing(){
            
            $data['users'] = Model_System_User::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/user/listing', 'c' => $data));
            
        }
        
        function action_add(){
            
            $val = Model_System_User::validate('add_user');
            
            if($val->run()){
                
                try{
                    Model_System_User::add($_POST);
                    Notify::success($_POST['first_name'].' '.$_POST['last_name']. ' Added');
                    Response::redirect('/system/user/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data = array();
            $this->response->body = View::factory('layout', array('l' => 'system/user/form', 'c' => $data));
            
        }
       
        function action_update($id){
            
            $val = Model_System_User::validate('update_user');
            
            if($val->run()){
                
                try{
                    Model_System_User::update($id, $_POST);
                    Notify::success($_POST['first_name'].' '.$_POST['last_name']. ' Updated');
                    Response::redirect('/system/user/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['row'] = Model_System_User::find($id);
            $this->response->body = View::factory('layout', array('l' => 'system/user/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_User::delete($id);
                Notify::success('User deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/user/listing');
        }

    }    