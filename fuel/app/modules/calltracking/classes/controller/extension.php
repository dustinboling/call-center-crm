<?php

    namespace CallTracking;

    class Controller_Extension extends Controller_Base{
        
        function action_index(){
            
        }
        
        function action_listing(){
            
            $data['extensions'] = Model_Extension::findAll();
            $this->response->body = \View::factory('layout', array('l' => 'extension/listing', 'c' => $data));
            
        }
        
        function action_add(){
            
            $val = Model_Extension::validate('add_extension');
            
            if($val->run()){
                
                Model_Extension::add($_POST);
                \Notify::success($_POST['name'] . ' Added');
                \Response::redirect('/calltracking/extension/listing');
                
            }else{
                $errors = $val->show_errors();
                if(!empty($errors)){
                    \Notify::setFlash((string)$val->show_errors(),'error','block');
                }
            }
            
            $this->response->body = \View::factory('layout', array('l' => 'extension/add', 'c' => array()));
            
        }
        
        function action_update($id){
            
            $val = Model_Extension::validate('add_extension');
            
            if($val->run()){
                
                Model_Extension::update($id, $_POST);
                \Notify::success($_POST['name'] . ' Updated');
                \Response::redirect('/calltracking/extension/listing');
                
            }else{
                $errors = $val->show_errors();
                if(!empty($errors)){
                    \Notify::setFlash((string)$val->show_errors(),'error','block');
                }
            }
            
            $data['extension'] = Model_Extension::find($id);
            
            $this->response->body = \View::factory('layout', array('l' => 'extension/update', 'c' => $data));
            
        }
        
        function action_delete($id){
            
            try{
                Model_Extension::delete($id);
            }catch(\Exception $e){
                \Notify::setFlash($e);
            }
            
            \Response::redirect('calltracking/extension/listing');
            
        }
        
    }    