<?php

    class Controller_System_Form extends Controller_System_Base{
       
        function action_listing(){
            
            $data['forms'] = Model_System_Form::findAll();
            $this->response->body = View::factory('layout', array('l' => 'system/form/listing', 'c' => $data));
            
        }
        
        function action_add(){
            
            $val = Model_System_Form::validate('add_form');
            
            if($val->run()){
                
                try{
                    if(!empty($_FILES['file']) && !$_FILES['file']['error']){
                        $_POST['file'] = Model_System_Form::saveFile($_POST['name'], $_FILES['file']);
                    }
                    Model_System_Form::add($_POST);
                    Notify::success($_POST['name'].' Added');
                    Response::redirect('/system/form/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/form/form', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_System_Form::validate('update_form');
            
            if($val->run()){
                
                try{
                    if(!empty($_FILES['file']) && !$_FILES['file']['error']){
                        $_POST['file'] = Model_System_Form::saveFile($_POST['name'], $_FILES['file']);
                    }
                    Model_System_Form::update($id, $_POST);
                    Notify::success($_POST['name'].' Updated');
                    Response::redirect('/system/form/listing');
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['row'] = Model_System_Form::find($id);
            $data['fields'] = Model_System_ObjectFields::findAll(1);
            $this->response->body = View::factory('layout', array('l' => 'system/form/form', 'c' => $data));
            
        }
        
        function action_delete($id){
            try{
                Model_System_Form::delete($id);
                Notify::success('Form deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/form/listing');
        }
        
    }    