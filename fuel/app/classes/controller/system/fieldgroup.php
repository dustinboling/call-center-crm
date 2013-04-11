<?php

    class Controller_System_FieldGroup extends Controller_Base{
        
        function action_add($type, $object_id, $parent_id = 0){
            
            $val = Model_System_FieldGroup::validate('add_fieldgroup');
            
             if($val->run()){
                 
                 $_POST['type'] = $type;
                 $_POST['object_id'] = $object_id;
                 $_POST['parent_id'] = $parent_id;
                 
                 try{
                    Model_System_FieldGroup::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/field/listing/'.$object_id);
                 }catch(Exception $e){
                     Notify::error($e);
                 }
                 
             }
            
            $data = array();
            $this->response->body = View::factory('layout', array('l' => 'system/fieldgroup/form', 'c' => $data));
            
        }
        
        function action_update($type, $object_id, $id){
            
            $val = Model_System_FieldGroup::validate('add_fieldgroup');
            
             if($val->run()){
                 
                 try{
                    Model_System_FieldGroup::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/field/listing/'.$object_id);
                 }catch(Exception $e){
                     Notify::error($e);
                 }
                 
             }
            
            $data['row'] = Model_System_FieldGroup::find($id);
            $this->response->body = View::factory('layout', array('l' => 'system/fieldgroup/form', 'c' => $data));
            
        }
        
        function action_delete($type, $object_id, $id){
            
            try{
                Model_System_FieldGroup::delete($id);
                Notify::success('Item Deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            
            Response::redirect('/system/field/listing/'.$object_id);
            
        }
        
        function action_resort($type){
            parse_str($_POST['order']);

            if(!empty($containers)){
               
                $i = 1;
                $sorts = array();
                foreach($containers as $c){
                    $sorts[$c] = $i;
                    $i++;
                }
                
                Model_System_FieldGroup::resort($sorts);
                
            }elseif(!empty($sections)){
                
                $i = 1;
                $sorts = array();
                foreach($sections as $s){
                    $sorts[$s] = $i;
                    $i++;
                }
                
                Model_System_FieldGroup::resort($sorts);
                
            }
        }
        
    }