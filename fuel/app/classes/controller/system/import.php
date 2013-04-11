<?php

    class Controller_System_Import extends Controller_System_Base{
        
        function action_listing(){
            
            $data['imports'] = Model_System_Import::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/import/listing', 'c' => $data));
            
        }
                
        function action_add(){
            
            $val = Model_System_Import::validate('add_import');
            
            if($val->run()){
                
                try{
                    Model_System_Import::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/import/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['fields'] = Model_System_ObjectFields::findAll(1); 
            $this->response->body = View::factory('layout', array('l' => 'system/import/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_Import::validate('add_import');
            
            if($val->run()){
                
                try{
                    Model_System_Import::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/import/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['row'] = Model_System_Import::find($id);
            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/import/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_Import::delete($id);
                Notify::success('Import Template deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/import/listing');
        }
        
    }