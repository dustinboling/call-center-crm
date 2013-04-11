<?php

    class Controller_System_Export extends Controller_System_Base{
        
        function action_listing(){
            
            $data['exports'] = Model_System_Export::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/export/listing', 'c' => $data));
            
        }
                
        function action_add(){
            
            $val = Model_System_Export::validate('add_export');
            
            if($val->run()){
                
                try{
                    Model_System_Export::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/export/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/export/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_Export::validate('add_export_template');
            
            if($val->run()){
                
                try{
                    Model_System_Export::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/export/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['row'] = Model_System_Export::find($id);
            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/export/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_Export::delete($id);
                Notify::success('Export Template deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/export/listing');
        }
        
    }