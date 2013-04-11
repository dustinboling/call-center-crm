<?php

    class Controller_System_FieldOption extends Controller_Base{
        
        function action_listing($field_id){
            
            $data['field'] = Model_System_ObjectFields::find($field_id);
            $data['options'] = Model_System_FieldOption::findByField($field_id);
            $this->response->body = View::factory('layout', array('l' => 'system/fieldoption/listing', 'c' => $data));
            
        }
        
        function action_add($field_id){
            
            $val = Model_System_FieldOption::validate('add_fieldoption');
            
             if($val->run()){
                 
                 $_POST['object_field_id'] = $field_id;
                 
                 try{
                    Model_System_FieldOption::add($_POST);
                    Notify::success($_POST['value']. ' Added');
                    Response::redirect('/system/fieldoption/listing/'.$field_id);
                 }catch(Exception $e){
                     Notify::error($e);
                 }
                 
             }
            
            $data['field'] = Model_System_ObjectFields::find($field_id);
            $this->response->body = View::factory('layout', array('l' => 'system/fieldoption/form', 'c' => $data));
            
        }
        
        function action_update($field_id, $id){
            
            $val = Model_System_FieldOption::validate('update_fieldoption');
            
             if($val->run()){
                 
                 try{
                    Model_System_FieldOption::update($id, $_POST);
                    Notify::success($_POST['value']. ' Updated');
                    Response::redirect('/system/fieldoption/listing/'.$field_id);
                 }catch(Exception $e){
                     Notify::error($e);
                 }
                 
             }
            
            $data['field'] = Model_System_ObjectFields::find($field_id);
            $data['row'] = Model_System_FieldOption::find($id);
            $this->response->body = View::factory('layout', array('l' => 'system/fieldoption/form', 'c' => $data));
            
        }
        
        function action_delete($field_id, $id){
            
            try{
                Model_System_FieldOption::delete($id);
                Notify::success('Option Deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            
            Response::redirect('/system/fieldoption/listing/'.$field_id);
            
        }
        
        function action_resort($type){
            parse_str($_POST['order']);

               
            $i = 1;
            $sorts = array();
            foreach($options as $o){
                $sorts[$o] = $i;
                $i++;
            }

            Model_System_FieldOption::resort($sorts);

        }
        
    }