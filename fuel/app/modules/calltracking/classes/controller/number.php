<?php

    namespace CallTracking;
    
    class Controller_Number extends Controller_Base{
        
        function action_listing($type = 'purchased'){
            
            $data['numbers'] = Model_Number::findByType($type);
            
            $this->response->body = \View::factory('layout', array('l' => 'number/'.$type, 'c' => $data));
            
        }
        
        function action_purchase(){
            
            if($_POST){
                
                if(isset($_POST['numbers'])){
                
                    foreach($_POST['numbers'] as $number){
                        try{
                            Model_Number::purchase($number);
                            \Notify::success($number .' was successfully added to your account');
                        }catch(Exception $e){
                            \Notify::error($e);
                        }    
                    }

                    \Response::redirect('/calltracking/number/listing');
                    
                }
            }
            
            $data['states'] = \FormSelect::states();
            $this->response->body = \View::factory('layout', array('l' => 'number/purchase', 'c' => $data));
            
        }
        
        function action_add(){
            
            $val = Model_Number::validate('add_number');
            
            if($val->run()){
                
                Model_Number::add($_POST);
                \Notify::success($_POST['label'] . ' Added');
                \Response::redirect('/calltracking/number/listing/internal');
                
            }else{
                $errors = $val->show_errors();
                if(!empty($errors)){
                    \Notify::setFlash((string)$val->show_errors(),'error','block');
                }
            }
            
            $data = array();
            $this->response->body = \View::factory('layout', array('l' => 'number/add', 'c' => $data));
            
        }
        
        function action_update($id){
            
            $val = Model_Number::validate('update_number');
            
            if($val->run()){

                Model_Number::update($id, $_POST);
                \Notify::success($_POST['label'] . ' Updated');
                \Response::redirect('/calltracking/number/listing/internal');
                
            }else{
                $errors = $val->show_errors();
                if(!empty($errors)){
                    \Notify::setFlash((string)$val->show_errors(),'error','block');
                }
            }
            
            $data['number'] = Model_Number::find($id);

            $this->response->body = \View::factory('layout', array('l' => 'number/update', 'c' => $data));
            
        }
        
        function action_delete($id){
            
            try{
                Model_Number::delete($id);
                \Notify::success('Number Deactivated');
            }catch(Exception $e){
                \Notify::error($e);
            }
            
            \Response::redirect('/calltracking/number/listing/internal');
            
        }
        
    }
        