<?php

    class Model_Event extends Model{
        
        static function add($data){

            if(!isset($data['time']) || empty($data['time'])){
                $data['time'] = '12:00:00';
            }
            
            if(isset($data['date'])){
                $ts = strtotime($data['date'] . ' ' . $data['time']);
                
                if(!$ts){
                    throw new Exception($_POST['date'] . ' ' . $_POST['time'] . 'is not a valid date');
                }
                
                $data['at'] = date('Y-m-d H:i:s', $ts);
                
                unset($data['date'], $data['time']);

            }
            
            $data['alert_at'] = date('Y-m-d H:i:s', strtotime($data['alert_offset'], strtotime($data['at'])));
            unset($data['alert_offset']);
            
            $data['created'] = date('Y-m-d H:i:s');
            $result = DB::insert('events')->set($data)->execute();
        }
        
        static function sendReminderEmails(){
            
            $result = DB::select('u.email','e.id','e.case_id','e.title','e.description','e.at')->from(array('events','e'))
                            ->join(array('users','u'))->on('e.user_id', '=', 'u.id')
                            ->where('e.email_popup', '=', 1)
                            ->where('e.alert_at', 'between', array(date('Y-m-d H:i:s'), date('Y-m-d H:i:s', strtotime('+5 minutes'))))
                            ->where('e.email_sent', '=', 0)
                            ->execute();
            
            if(!count($result)){
                return;
            }
            
            $case_ids = array();
            $emails = array();
            foreach($result->as_array() as $a){
                $case_ids[] = $a['case_id'];
                $emails[$a['case_id']] = $a;
            }
            
            $cases = Model_Case::findByIDs($case_ids);
            
            foreach($cases as $c){
                
                $to = $emails[$c['id']]['email'];
                $subject = 'Appointment Reminder: '.date('m/d g:ia', strtotime($emails[$c['id']]['at'])).(!empty($c['first_name'])?' with ':'').$c['first_name'].' '.$c['last_name'];
                $message = $emails[$c['id']]['title']."\r\n".$emails[$c['id']]['description']."\r\n".'http://crm.pinnacletaxadvisors.com/case/view/'.$c['id'];
                
                mail($to, $subject, $message, "From: noreply@pinnacletaxadvisors.com\r\n");
                self::completeReminderEmail($emails[$c['id']]['id']);
            }
            
        }
        
        static function completeReminderEmail($id){
            DB::update('events')->set(array('email_sent' => 1))->where('id', '=', $id)->execute();
        }
        
        static function getPopups(){
            
            $result = DB::select('e.id','e.case_id','e.title','e.description','e.at')->from(array('events','e'))
                            ->where('e.alert_popup', '=', 1)
                            ->where('e.popup_triggered', '=', 0)
                            ->where('e.alert_at', 'between', array(date('Y-m-d H:i:s'), date('Y-m-d H:i:s', strtotime('+2 minutes'))))
                            ->where('e.user_id', '=', $_SESSION['user']['id'])
                            ->execute();
            
            if(!count($result)){
                return array();
            }
            
            $case_ids = array();
            $alerts = array();
            foreach($result->as_array() as $a){
                $case_ids[] = $a['case_id'];
                $alerts[$a['case_id']] = $a;
            }
            
            $cases = Model_Case::findByIDs($case_ids);
            
            $popups = array();
            foreach($cases as $c){
                $popups[] = array(
                                  'alert_id' => $alerts[$c['id']]['id'],  
                                  'case_id' => $c['id'],
                                  'first_name' => $c['first_name'],
                                  'last_name' => $c['last_name'],
                                  'at' => date('m/d g:ia', strtotime($alerts[$c['id']]['at'])),
                                  'title' => $alerts[$c['id']]['title'],
                                 );
            }
            
            return $popups;
            
        }
        
        static function completeReminderPopup($id){
            DB::update('events')->set(array('popup_triggered' => 1))->where('id', '=', $id)->execute();
        }        
    }