<?php

    class Model_Event extends Model{
        
        static function find($id){
            
            $result = DB::select()->from('events')
                        ->where('id', '=', $id)
                        ->where('user_id', '=', $_SESSION['user']['id'])
                        ->execute();
            
            return current($result->as_array());
            
        }
        
        static function findByUser($user_id, $offset = 0, $limit = 100){
            
            $result = DB::select()->from('events')
                        ->where('user_id', '=', $user_id)
                        ->where('completed', 'is', null)
                        ->offset($offset)
                        ->limit($limit)
                        ->order_by('at')
                        ->execute();
            
            return $result->as_array();
            
        }
        
        static function findByCase($case_id){
            
            $result = DB::select()->from('events')
                        ->where('case_id', '=', $case_id)
                        ->where('user_id', '=', $_SESSION['user']['id'])
                        ->where('completed', 'is', null)
                        ->execute();
            
            return $result->as_array();
            
        }
        
        static function findByDate($start_date, $end_date = null){
            
            $start_date = date('Y-m-d', strtotime($start_date));
            
            if(empty($end_date)){
                $end_date = date('Y-m-d', strtotime($start_date)). ' 23:59:59';
            }else{
                $end_date = date('Y-m-d', strtotime($end_date)). ' 23:59:59';
            }
            
            $result = DB::select()->from('events')
                        ->where('user_id', '=', $_SESSION['user']['id'])
                        ->where('at', 'between', array($start_date, $end_date))
                        ->where('completed', 'is', null)
                        ->order_by('at')
                        ->execute();

            return $result->as_array();
            
        }
        
        static function findByStatus($status){
            
            $query = DB::select()->from('events')
                        ->where('user_id', '=', $_SESSION['user']['id'])
                        ->order_by('at');
                    
            if($status == 'overdue'){
                $query->where('at', '<', date('Y-m-d H:i:s'))
                        ->where('completed', 'is', null);
            }        
            
            $result = $query->execute();

            return $result->as_array();

        }
        
        static function findCountByUserID($user_id){
            
            $result = DB::select(DB::expr('count(id) as total_records'))->from('events')
                        ->where('user_id', '=', $user_id)
                        ->where('completed', 'is', null)
                        ->execute();
            
            $row = current($result->as_array());
            return $row['total_records'];
            
        }
        
        static function update($id, $data){
            
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
            
            DB::update('events')->set($data)->where('id', '=', $id)->execute();
            
        }
        
        static function complete($id){
            DB::update('events')->set(array('completed' => date('Y-m-d H:i:s')))->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            
            DB::delete('events')->where('id', '=', $id)->execute();
            
        }

        
        static function add($data){

            if(isset($data['date'])){
                
                if(!isset($data['time']) || empty($data['time'])){
                    $data['time'] = '12:00:00';
                }
                
                $ts = strtotime($data['date'] . ' ' . $data['time']);
                
                if(!$ts){
                    throw new Exception($_POST['date'] . ' ' . $_POST['time'] . 'is not a valid date');
                }
                
                $data['at'] = date('Y-m-d H:i:s', $ts);
                
                unset($data['date'], $data['time']);

            }
            
            if(!empty($data['alert_offset'])){
                $data['alert_at'] = date('Y-m-d H:i:s', strtotime($data['alert_offset'], strtotime($data['at'])));
            }else{
                $data['alert_at'] = $data['at'];
            }
            
            unset($data['alert_offset']);
            
            $data['created'] = date('Y-m-d H:i:s');
            $result = DB::insert('events')->set($data)->execute();
        }
        
        static function sendReminderEmails(){
            
            $result = DB::select('u.email','e.id','e.case_id','e.title','e.description','e.at')->from(array('events','e'))
                            ->join(array('users','u'))->on('e.user_id', '=', 'u.id')
                            ->where('e.alert_email', '=', 1)
                            ->where('e.email_sent', '=', 0)
                            ->where('e.alert_at', '<=', date('Y-m-d H:i:s'))
                            ->execute();

            if(!count($result)){
                return;
            }
            
            $case_ids = array();
            $emails = array();
            foreach($result->as_array() as $a){
                $case_ids[] = $a['case_id'];
            }
            
            $cases = Model_Case::findByIDs($case_ids);
            
            foreach($result->as_array() as $a){
                
                $c = array('first_name'=>'','last_name'=>'','id'=>'');
                if(!empty($a['case_id']) && isset($cases[$a['case_id']])){
                    $c = $cases[$a['case_id']];
                }
                
                $to = $a['email'];
                $subject = 'Appointment Reminder: '.date('m/d g:ia', strtotime($a['at'])).(!empty($c['first_name'])?' with ':'').$c['first_name'].' '.$c['last_name'];
                $message = $a['title']."\r\n".$a['description']."\r\n";
                if(!empty($c['id'])){
                    $message .= 'http://crm.pinnacletaxadvisors.com/case/view/'.$c['id'];
                }
                
                mail($to, $subject, $message, "From: noreply@pinnacletaxadvisors.com\r\n");
                self::completeReminderEmail($a['id']);
                
            }
            
        }
        
        static function completeReminderEmail($id){
            DB::update('events')->set(array('email_sent' => 1))->where('id', '=', $id)->execute();
        }
        
        static function getPopups(){
            
            $result = DB::select('e.id','e.case_id','e.title','e.description','e.at')->from(array('events','e'))
                            ->where('e.alert_popup', '=', 1)
                            ->where('e.popup_triggered', '=', 0)
                            ->where('e.alert_at', '<=', date('Y-m-d H:i:s'))
                            ->where('e.user_id', '=', $_SESSION['user']['id'])
                            ->execute();
            
            if(!count($result)){
                return array();
            }
            
            $case_ids = array();
            $alerts = array();
            foreach($result->as_array() as $a){
                $case_ids[] = $a['case_id'];
            }
            
            $cases = Model_Case::findByIDs($case_ids);
            
            $popups = array();
            foreach($result->as_array() as $a){
                
                $c = array('first_name'=>'','last_name'=>'','id'=>'');
                if(!empty($a['case_id']) && isset($cases[$a['case_id']])){
                    $c = $cases[$a['case_id']];
                }
                
                $popups[] = array(
                                  'alert_id' => $a['id'],  
                                  'case_id' => $c['id'],
                                  'first_name' => $c['first_name'],
                                  'last_name' => $c['last_name'],
                                  'at' => date('m/d g:ia', strtotime($a['at'])),
                                  'title' => $a['title'],
                                 );
            }
            
            return $popups;
            
        }
        
        static function completeReminderPopup($id){
            DB::update('events')->set(array('popup_triggered' => 1))->where('id', '=', $id)->execute();
        }        
    }