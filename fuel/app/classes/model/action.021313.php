<?php

    class Model_Action extends Model{
        
        //TODO this can probably be rewritten to efficiently handle batches as well
        static function run($case_id, $action_id, $note = '', $user_id = 0, $inc_count = true){
            
            $action = Model_System_Action::find($action_id);

            Model_Log::addActivity($case_id, 'action', $action['name'], $note, $user_id);
            
            if(!empty($action['tracking']) && $action['tracking'] != 'none'){
                Model_Log::trackAction($action['tracking'],$user_id, $case_id, $action_id, $action['group_id']);
            }
            
            if($inc_count){
                Model_Case::incActionCount($case_id);
            }
            
            $result = DB::select('at.label','asts.target_id')
                                ->from(array('actions_tasks','asts'))
                                ->join(array('action_tasks', 'at'))->on('at.id', '=', 'asts.task_id')
                                ->where('asts.action_id', '=', $action_id)
                                ->execute();
            
            foreach($result->as_array() as $row){
                $action = $row['label'];
                self::$action($case_id, $row['target_id']);
            }
            
        }

        static function runBatch($case_ids, $action_id){
            
            if(empty($case_ids)){
                return 'No cases selected for batch';
            }
            
            if(!is_array($case_ids)){
                $case_ids = array($case_ids);
            }
            
            $action = Model_System_Action::find($action_id);
            
            $result = DB::select('at.label','asts.target_id')
                                ->from(array('actions_tasks','asts'))
                                ->join(array('action_tasks', 'at'))->on('at.id', '=', 'asts.task_id')
                                ->where('asts.action_id', '=', $action_id)
                                ->execute();
            
            foreach($case_ids as $case_id){

                Model_Log::addActivity($case_id, 'action', $action['name'], 'Batch Action', $_SESSION['user']['id']);
                
                foreach($result->as_array() as $row){
                    $action_task = $row['label'];
                    self::$action_task($case_id, $row['target_id']);
                }
            }
            
            return count($case_ids) . ' case'.(count($case_ids)==1?'':'s').' ran action ' . $action['name'];
            
        }
        
        static function changeStatus($case_id, $target_id){      
            Model_Case::updateStatus($case_id, $target_id);
        }
        
        static function completeWorkflow($case_id, $target){
            
        }
        
        static function sendEmail($case_id, $target_id){
            //throw new Exception('Send Email is not currently available in production');
            $fields = Model_Case::find($case_id);
            $rep = Model_System_User::find($fields['sales_rep_id']);
            
            $email = Model_System_Email::find($target_id);
            
            $email = Model_System_ObjectFields::parseTemplate($email, $fields, array('user_name' => $_SESSION['user']['first_name'].' '.$_SESSION['user']['last_name'], 'sales_rep_email' => $rep['email'], 'sales_rep_name' => $rep['first_name'] . ' ' . $rep['last_name']));
            
            $headers = array('From: '.$email['from']);
            if(!empty($email['cc'])){ $headers[] = 'Cc: '.$email['cc']; }
            if(!empty($email['bcc'])){ $headers[] = 'Bcc: '.$email['bcc']; }
            
            mail($email['to'], $email['subject'], $email['message'], implode("\r\n", $headers)."\r\n");
            //Model_Case::incActionCount($case_id);
        }
        
        static function sendText($case_id, $target_id){
            throw new Exception('Send Text is not currently available in production');
            $fields = Model_System_TemplateFields::load($app_id);
            $text = Model_System_SMS::find($target_id);
            
            $text = Model_System_templateFields::parseTemplate($text, $fields);

            $twilio_config = Config::get('twilio');
            Twilio::init($twilio_config['account_sid'], $twilio_config['auth_token']);
            //$twilio->account->sms_messages->create('+1'.$text['from_number'], '+1'.$text['to'], $text['message']);
            Twilio::getClient()->account->sms_messages->create('+1'.$text['from_number'], '+16072449936', $text['message']);
            //Model_Case::incActionCount($case_id);
            
        }
        
        static function makeCall($case_id, $target_id){
            throw new Exception('Make Call is not currently available in production');
            $fields = Model_System_TemplateFields::load($app_id);
            $call = Model_System_Call::find($target_id);
            
            $call = Model_System_templateFields::parseTemplate($call, $fields);
            
            $twilio_config = Config::get('twilio');
            Twilio::init($twilio_config['account_sid'], $twilio_config['auth_token']);
            //$twilio->account->sms_messages->create('+1'.$text['from_number'], '+1'.$text['to'], 'http://'.$_SERVER['HTTP_HOST'].'/notification/call/'.$app_id.'/'.$target_id);
            Twilio::getClient()->account->calls->create('+1'.$call['from_number'], '+16072449936', 'http://'.$_SERVER['HTTP_HOST'].'/notification/call/'.$app_id.'/'.$target_id);
            //Model_Case::incActionCount($case_id);
            
        }
        
        static function communicate($case_id, $target_id){
            
        }
        
        static function export($case_id, $target_id){

            $export = Model_System_Export::find($target_id);

            if($export['active']){
                
                $fields = Model_Case::find($case_id);
                
                //implode arrays to strings
                foreach($fields as $k => $v){
                    if(is_array($v)){
                        $fields[$k] = implode(',', $v);
                    }
                }

                if(substr_count($export['data_template'], 'pay_')){
                    $payment_plan = Model_Payment::getPaymentPlanSummary($case_id);
                    $fields = array_merge($fields, $payment_plan);
                }
            
                $data = Model_System_ObjectFields::parseTemplate($export, $fields);

                Model_Log::addActivity($case_id, 'task', 'Case Exported: '.$data['name']);
                self::httpRequest($data['url'], $data['type'], $data['data_template']);

                
            }
            
        }
        
        static function httpRequest($url, $method, $data){
            
            $ch = curl_init();
            
            if(substr($url,0,5) == 'https'){
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            }

            if(strtoupper($method) == 'POST'){
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }else{
                $url .= $data;
            }            

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $resp = curl_exec($ch);
            curl_close($ch);
            //disabled - not being used and generates about 100MB/week of logs.
            //DB::insert('log_exports')->set(array('url' => $url, 'data' => serialize($data), 'response' => $resp))->execute();
        }
        
        
        
    }