<?php

    namespace CallTracking;

    class Model_Call extends \Model{
        
        static function save($data){
            
            \DB::insert('ct_incoming_posts')->set(array('data' => serialize($data)))->execute();
            
            $result = \DB::select('id','org_id','campaign_id','receiving_number')
                        ->from('ct_calls')
                        ->where('twilio_id', $data['CallSid'])
                        ->execute();
            
            if(count($result)){

                $type = 'update';
            
            }else{
                
                $type = 'add';
                
                if(preg_match('/^\+1/',$data['Called'])){
                    $data['Called'] = substr($data['Called'],2);
                }
            
                $result = \DB::select(array('n.id','receiving_number'),'n.org_id', array('c.id', 'campaign_id'))
                            ->from(array('ct_numbers', 'n'))
                            ->join(array('ct_campaigns', 'c'))->on('n.id', '=', 'c.incoming_number')
                            ->where('n.number', $data['Called'])
                            ->where('c.active', 1)
                            ->execute();

            }    
            
            $row = current($result->as_array());

            $call = array(
                            'org_id' => $row['org_id'],
                            'campaign_id' => $row['campaign_id'],
                            'receiving_number' => $row['receiving_number'],
                            'twilio_id' => $data['CallSid'],
                            'dial_status' => $data['DialCallStatus'],
                            'call_status' => $data['CallStatus'],
                            'caller_number' => $data['Caller']
                          );
            
            $caller_location = array('caller_city' => '', 'caller_state' => '', 'caller_zip' => '');
            
            if(!empty($data['CallerCity'])){
                $caller_location = array(
                                         'caller_city' => $data['CallerCity'], 
                                         'caller_state' => $data['CallerState'], 
                                         'caller_zip' => $data['CallerZip']
                                        );
            }
            
            if(isset($data['RecordingUrl'])){
                $call['recording_url'] = $data['RecordingUrl'];
            }
            
            if(isset($data['RecordingDuration'])){
                $call['duration'] = $data['RecordingDuration'];
            }
            
            $call = array_merge($call, $caller_location);
            
            if($type == 'update'){
                $call['end_time'] = date('Y-m-d H:i:s');
                \DB::update('ct_calls')->set($call)->where('id', $row['id'])->execute();
            }else{
                $call['start_time'] = date('Y-m-d H:i:s');
                \DB::insert('ct_calls')->set($call)->execute();
            }
            
        }
        
        static function find($call_id){
            
            $result = \DB::select('c.id','c.caller_number','caller_city','caller_state',array('n1.number', 'receiving_number'), array('n1.label', 'receiving_number_label'),'c.start_time','notes','duration','recording_url',array('d.name','disposition'), array('e.name','rep_name'))
                        ->from(array('ct_calls', 'c'))
                        ->join(array('ct_numbers', 'n1'))->on('c.receiving_number', '=', 'n1.id')
                        ->join(array('ct_dispositions', 'd'),'LEFT')->on('c.disposition', '=', 'd.id')
                        ->join(array('ct_extensions', 'e'), 'LEFT')->on('e.extension', '=', 'c.receiving_extension')
                        ->where('c.id', $call_id)
                        ->where('c.org_id', $_SESSION['user']['org_id'])
                        ->execute();
            
            return current($result->as_array());
            
        }
        
        static function findByCampaign($campaign_id, $offset = 0, $limit = 25){
            
            $result = \DB::select('c.id','c.caller_number','caller_city','caller_state',array('n1.number', 'receiving_number'), array('n1.label', 'receiving_number_label'),'c.start_time','c.receiving_extension','notes','duration','recording_url',array('d.name','disposition'), array('e.name','rep_name'))
                        ->from(array('ct_calls', 'c'))
                        ->join(array('ct_numbers', 'n1'))->on('c.receiving_number', '=', 'n1.id')
                        ->join(array('ct_dispositions', 'd'),'LEFT')->on('c.disposition', '=', 'd.id')
                        ->join(array('ct_extensions', 'e'), 'LEFT')->on('e.extension', '=', 'c.receiving_extension')
                        ->where('c.campaign_id', $campaign_id)
                        ->where('c.org_id', $_SESSION['user']['org_id'])
                        ->order_by('c.start_time', 'desc')
                        ->limit($limit)
                        ->offset($offset)
                        ->execute();
            
            return $result->as_array();
            
        }
        
        static function countByCampaign($campaign_id){
            $result = \DB::select(\DB::expr('COUNT(id) as total_items'))->from('ct_calls')->where('campaign_id', '=', $campaign_id)->execute();
            $row = current($result->as_array());
            return $row['total_items'];
        }
        
        static function findByDate($start_date, $end_date = null, $offset = 0, $limit = 25){
            
            $result = \DB::select('c.id','c.caller_number','caller_city','caller_state',array('cp.name', 'campaign'), array('n1.number', 'receiving_number'), array('n1.label', 'receiving_number_label'),'c.start_time','c.receiving_extension','notes','duration','recording_url',array('d.name','disposition'), array('e.name','rep_name'))
                        ->from(array('ct_calls', 'c'))
                        ->join(array('ct_campaigns', 'cp'))->on('cp.id', '=', 'c.campaign_id')
                        ->join(array('ct_numbers', 'n1'))->on('c.receiving_number', '=', 'n1.id')
                        ->join(array('ct_dispositions', 'd'),'LEFT')->on('c.disposition', '=', 'd.id')
                        ->join(array('ct_extensions', 'e'), 'LEFT')->on('e.extension', '=', 'c.receiving_extension')
                        ->where('c.start_time', '>=', $start_date)
                        ->where('c.start_time', '<=', $end_date)
                        ->where('c.org_id', $_SESSION['user']['org_id'])
                        ->order_by('c.start_time', 'desc')
                        ->limit($limit)
                        ->offset($offset)
                        ->execute();
            
            return $result->as_array();
            
        }
        
        static function countByDate($start_date, $end_date = null){
            $result = \DB::select(\DB::expr('COUNT(id) as total_items'))->from('ct_calls')->where('start_time', '>=', $start_date)->where('start_time', '<=', $end_date)->where('org_id', $_SESSION['user']['org_id'])->execute();
            $row = current($result->as_array());
            return $row['total_items'];
        }
        
        static function findByFilter($campaign_id = null, $start_date = null, $end_date = null, $offset = 0, $limit = 25){
            
            $result = \DB::select('c.id','c.caller_number','caller_city','caller_state',array('cp.name', 'campaign'), array('n1.number', 'receiving_number'), array('n1.label', 'receiving_number_label'),'c.start_time','c.receiving_extension','notes','duration','recording_url',array('d.name','disposition'), array('e.name','rep_name'))
                        ->from(array('ct_calls', 'c'))
                        ->join(array('ct_campaigns', 'cp'))->on('cp.id', '=', 'c.campaign_id')
                        ->join(array('ct_numbers', 'n1'))->on('c.receiving_number', '=', 'n1.id')
                        ->join(array('ct_dispositions', 'd'),'LEFT')->on('c.disposition', '=', 'd.id')
                        ->join(array('ct_extensions', 'e'), 'LEFT')->on('e.extension', '=', 'c.receiving_extension')
                        ->where('c.org_id', $_SESSION['user']['org_id']);
            
            if(!empty($campaign_id)){
                $result->where('c.campaign_id', '=', $campaign_id);
            }
            
            if(!empty($start_date) && !empty($end_date)){
                $result->where('c.start_time', '>=', $start_date)
                       ->where('c.start_time', '<=', $end_date);
            }
            
            $result->order_by('c.start_time', 'desc');
            
            $result = $result->order_by('c.start_time', 'desc')
                        ->limit($limit)
                        ->offset($offset)
                        ->execute();
            
            return $result->as_array();
            
        }
        
        static function countByFilter($campaign_id = null, $start_date = null, $end_date = null){
            $result = \DB::select(\DB::expr('COUNT(id) as total_items'))->from('ct_calls');
            
            if(!empty($campaign_id)){
                $result->where('campaign_id', '=', $campaign_id);
            }
            
            if(!empty($start_date) && !empty($end_date)){
                $result->where('start_time', '>=', $start_date)
                       ->where('start_time', '<=', $end_date);
            }        
                    
            $result = $result->execute();
            
            $row = current($result->as_array());
            return $row['total_items'];
        }
                
        static function increment_notes($call_id){
            
            $call_id = \DB::quote($call_id);
            $org_id = \DB::quote($_SESSION['user']['org_id']);
            
            \DB::query("UPDATE ct_calls SET notes = notes+1 WHERE id = {$call_id} AND org_id = {$org_id}")->execute();
            
        }
        
        static function decrement_notes($call_id){
            
            $call_id = \DB::quote($call_id);
            $org_id = \DB::quote($_SESSION['user']['org_id']);
            
            \DB::query("UPDATE ct_calls SET notes = notes-1 WHERE id = {$call_id} AND org_id = {$org_id}")->execute();
            
        }
        
        static function set_disposition($call_id, $disposition_id){
            
            \DB::update('ct_calls')
                    ->set(array('disposition' => $disposition_id))
                    ->where('id', '=', $call_id)
                    ->where('org_id', '=', $_SESSION['user']['org_id'])
                    ->execute();
            
        }
        
    }