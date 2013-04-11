<?php


    class Controller_System_Field extends Controller_System_Base{
        
        function action_listing($object_id){
            
            $data['object'] = Model_System_Object::find($object_id);
            $data['fields'] = Model_System_Field::findAll($object_id);
            $this->response->body = View::factory('layout', array('l' => 'system/field/listing', 'c' => $data));
            
        }
                
        function action_add($object_id){
            
            $val = Model_System_Field::validate('add_field');
            
            if($val->run()){
                
                try{
                    Model_System_Field::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/field/listing/'.$object_id);
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['object'] = Model_System_Object::find($object_id);
            $data['field_validation'] = array();
            $data['field_types'] = Model_System_Field::findAllTypes();
            $this->response->body = View::factory('layout', array('l' => 'system/field/form', 'c' => $data));
            
        }
        
        function action_update($object_id, $id){
            
            $val = Model_System_Field::validate('add_field');
            
            if($val->run()){
                
                try{
                    Model_System_Field::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/field/listing/'.$object_id);
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['object'] = Model_System_Object::find($object_id);
            $data['field_validation'] = array();
            $data['field_types'] = Model_System_Field::findAllTypes();
            $data['row'] = Model_System_Field::find($id);
            $this->response->body = View::factory('layout', array('l' => 'system/field/form', 'c' => $data));
            
        }
        
        function action_delete($object_id, $id){
            try{
                Model_System_Field::delete($id);
                Notify::success('Field deleted');
            }catch(Exception $e){
                Notify::error($e);
            }
            Response::redirect('/system/field/listing/'.$object_id);
        }
        
        function action_normalize_names(){
            
            $result = DB::select()->from('object_fields')->where('clean_name', '=', '')->execute();
            foreach($result->as_array() as $row){
                $clean_name = strtolower(preg_replace('/[^a-z0-9\_-]/i', '', str_replace(' ', '_', $row['name'])));
                DB::update('object_fields')->set(array('clean_name' => $clean_name))->where('id', '=', $row['id'])->execute();
            }
            
        }
        
    }