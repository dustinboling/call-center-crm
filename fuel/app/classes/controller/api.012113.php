<?php

    class Controller_Api extends Controller{
        
        function action_import($id, $hash){

            Model_Log::addImport($_SERVER['REQUEST_METHOD'], serialize($_REQUEST));
            
            $fields = Model_System_ObjectFields::findAll(1);
            $import = Model_System_Import::find($id);

            if($import['hash'] != $hash){
                header('HTTP/1.1 401 Unauthorized');
                print 'You are not authorized to access this page. Please check your uri.';
                exit;
            }elseif(!$import['active']){
                print 'This endpoint has been deactivated.';
                exit;
            }
            
            $template_str = str_replace(array('{','}'),'',$import['data_template']);
            parse_str($template_str, $template);
            
            $where_str = str_replace(array('{','}'),'',$import['update_template']);
            parse_str($where_str, $where);
           
            $phone_fields = Model_System_ObjectFields::findByType(1, 10);
            $pf = array();
            foreach($phone_fields as $p){
                $pf[$p['clean_name']] = $p['clean_name'];
            }
     
            $data = array();
            foreach($template as $k => $v){
                if(isset($_REQUEST[$v])){
                    //if it's a phone field, clean it
                    $data[$k] = (in_array($k, $pf)? preg_replace('/[^0-9]/','', $_REQUEST[$v]):$_REQUEST[$v]);
                }
            }
            
            $action = null;
            if(isset($data['action'])){
                $action = $data['action'];
                unset($data['action']);
            }
            

            $update = array();
            foreach($where as $k => $v){
                if(isset($_REQUEST[$v])){
                    $update[$k] = $_REQUEST[$v];
                }
            }

            $case_id = null;
            if(!empty($update)){
                
                try{
                    $case = Model_Case::findByFields($update);
                }catch(Exception $e){
                    print $e->getMessage();
                }
                
                if(count($case) == 1){
                    $case = current($case);
                    $case_id = (int)$case['_id'];
                  }
                
            }

            if(!empty($data)){
                try{
                    $case_id = Model_Case::import($data, $case_id);
                }catch(Exception $e){
                    print $e->getMessage();
                }
            }
            
            if(!empty($case_id) && !empty($action)){
                
                try{
                    $action_id = Model_System_Action::findActionID($action);
                }catch(Exception $e){
                    print $e->getMessage();
                }
                
                if(!empty($action_id)){
                    try{
                        
                        $user_id = 0;
                        if(isset($_REQUEST['user_email']) && !empty($_REQUEST['user_email'])){
                            $user = Model_System_User::findByEmail($_REQUEST['user_email']);
                            if(!empty($user['id'])){
                                $user_id = $user['id'];
                            }
                        }
                       
                        Model_Action::run($case_id, $action_id, '', $user_id);
                    }catch(Exception $e){
                        print $e->getMessage();
                    }
                }

            }

            print '<p>Reference ID: '.$case_id.'</p>';
        }
        
        function action_send_reminder_emails(){
            //only trigger locally
            if($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR']){
                Model_Event::sendReminderEmails();
            }
        }
        
        function action_document_status(){
            Fuel::add_module('esign');
            Config::load('esign::esign');
            ESign\Model_Document::updateStatus($_GET['documentKey']);
        }
        
        function action_receive_payment($k = null){
            
            if($k != '1edca70335acac0e442f059181f25fccaa95fd79'){
                header('HTTP/1.0 401 Not Authorized');
                print 'You are not authorized to view this page';
                exit;
            }
            
            $payment = $_REQUEST;
            
            $errors = array();
            
            if(!is_numeric($payment['transaction_id'])){
                $error = true;
                $errors[] = 'Transaction ID must be numeric<br>';
            }
            
            if(empty($payment['case_id']) || !is_numeric($payment['case_id'])){
                $error = true;
                $errors[] = 'Case ID must be provided and numeric<br>';
            }
            
            if(empty($payment['amount']) || !is_numeric($payment['amount'])){
                $error = true;
                $errors[] = 'Amount must be provided and numeric<br>';
            }
            
            if(!empty($payment['commission']) && !is_numeric($payment['commission'])){
                $error = true;
                $errors[] = 'Commission must be numeric<br>';
            }
            
            if(empty($payment['created']) || !strtotime($payment['created'])){
                $error = true;
                $errors[] = 'Created must be provided and a valid date string<br>';
            }else{
                $payment['created'] = date('Y-m-d H:i:s', strtotime($payment['created']));
            }
            
            if(count($errors)){
                
                header('HTTP/1.0 400 Bad Request');
                print implode('<br>', $errors);
                exit;
                
            }else{
                
                $case = Model_Case::find($payment['case_id']);
                if(!empty($case['sales_rep_id'])){
                    $payment['sales_rep_id'] = $case['sales_rep_id'];
                }
                
                DB::insert('sf_payments')->set($payment)->execute();
                print 'Payment with transaction ID '.$payment['transaction_id']. ' received';
            }
            
        }
        
    }