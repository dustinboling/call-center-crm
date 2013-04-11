<?php


    class Controller_System_Field extends Controller_System_Base{
        
        function action_listing($object_id){
            
            $data['object'] = Model_System_Object::find($object_id);
            $data['sections'] = Model_System_FieldGroup::findAllSections();
            $containers = Model_System_FieldGroup::findAllContainers();
            $fields = Model_System_ObjectFields::findAll($object_id);
            
            $data['fields'] = array();
            foreach($fields as $f){
                $data['fields'][$f['section_id']][$f['container_id']][] = $f;
            }
            
            $data['containers'] = array();
            foreach($containers as $c){
                $data['containers'][$c['parent_id']][] = $c;
            }
            
            $this->response->body = View::factory('layout', array('l' => 'system/field/listing', 'c' => $data));
            
        }
                
        function action_add($object_id, $container_id){
            
            $val = Model_System_ObjectFields::validate('add_field');
            
            if($val->run()){
                
                $container = Model_System_FieldGroup::find($container_id);
                
                $_POST['clean_name'] = str_replace(' ', '_', preg_replace('/[^0-9a-z]/i','',strtolower($_POST['name'])));
                $_POST['object_id'] = $object_id;
                $_POST['container_id'] = $container_id;
                $_POST['section_id'] = $container['parent_id'];
                
                try{
                    Model_System_ObjectFields::add($_POST);
                    Notify::success($_POST['name']. ' Added');
                    Response::redirect('/system/field/listing/'.$object_id);
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['object'] = Model_System_Object::find($object_id);
            $data['field_validation'] = array();
            $data['field_types'] = Model_System_ObjectFields::findAllTypes();
            $this->response->body = View::factory('layout', array('l' => 'system/field/form', 'c' => $data));
            
        }
        
        function action_update($object_id, $id){
            
            $val = Model_System_ObjectFields::validate('add_field');
            
            if($val->run()){
                
                try{
                    Model_System_ObjectFields::update($id, $_POST);
                    Notify::success($_POST['name']. ' Updated');
                    Response::redirect('/system/field/listing/'.$object_id);
                }catch(Exception $e){
                    Notify::error($e);
                }
                
            }
            
            $data['object'] = Model_System_Object::find($object_id);
            $data['field_validation'] = array();
            $data['field_types'] = Model_System_ObjectFields::findAllTypes();
            $data['row'] = Model_System_ObjectFields::find($id);
            $this->response->body = View::factory('layout', array('l' => 'system/field/form', 'c' => $data));
            
        }
        
        function action_delete($object_id, $id){
            try{
                Model_System_ObjectFields::delete($id);
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

        function action_resort(){
            parse_str($_POST['order']);
            
            $i = 1;
            $sorts = array();
            foreach($fields as $f){
                $sorts[$f] = $i;
                $i++;
            }

            Model_System_ObjectFields::resort($sorts);
        }
        
    }