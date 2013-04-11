<?php

    namespace CallTracking;

    class Model_Campaign extends \Model{
        
        static function get_area_codes($state){
            
            $result = \DB::select('area_code')->from('ct_area_codes')->where('state', $state)->execute();
            return $result->as_array();
            
        }
        
        static function find($id){
            
            $result = \DB::select('c.id', 'c.name', 'c.incoming_number', 'c.forwarding_number', 'c.after_hours_forwarding', 'after_hours_start', 'after_hours_end', 'after_hours_number', array('n1.number', 'incoming_phone'), array('n2.number','forwarding_phone'), array('s.company', 'subaccount'))
                        ->from(array('ct_campaigns', 'c'))
                        ->join(array('ct_numbers', 'n1'))->on('c.incoming_number', '=', 'n1.id')
                        ->join(array('ct_numbers', 'n2'))->on('c.forwarding_number', '=', 'n2.id')
                        ->join(array('ct_subaccounts', 's'), 'LEFT')->on('c.subaccount_id', '=', 's.id')
                        ->where('c.org_id', $_SESSION['user']['org_id'])
                        ->where('c.id', $id)
                        ->execute();
            
            return current($result->as_array());
            
        }
        
        static function add($data){
            
            $data['created'] = date('Y-m-d H:i:s');
            $data['created_by'] = $_SESSION['user']['id'];
            $data['org_id'] = $_SESSION['user']['org_id'];
            
            $data = self::manageForwarding($data);
            
            list($insert_id, $rows_affected) = \DB::insert('ct_campaigns')->set($data)->execute();
            
            Model_Number::update($data['incoming_number'], array('campaign_id' => $insert_id));
            
            return $insert_id;
            
        }
        
        static function update($id, $data){
            
            $data = self::manageForwarding($data);
            \DB::update('ct_campaigns')->set($data)->where('org_id', '=', $_SESSION['user']['org_id'])->where('id', '=', $id)->execute();
            
        }
        
        static function delete($id){
            
            $result = self::find($id);
            
            self::update($id, array('active' => 0));
            Model_Number::update($result['incoming_number'], array('campaign_id' => 0));
        }
        
        static function manageForwarding($data){
            if($data['after_hours_forwarding']){
                $data['after_hours_start'] = ($data['ahf_start_meridiem'] == 'pm'?$data['ahf_start_hour']+12:$data['ahf_start_hour']).':'.$data['ahf_start_minute'].':00';
                $data['after_hours_end'] = ($data['ahf_end_meridiem'] == 'pm'?$data['ahf_end_hour']+12:$data['ahf_end_hour']).':'.$data['ahf_end_minute'].':00';;
            }else{
                $data['after_hours_start'] = '00:00:00';
                $data['after_hours_end'] = '00:00:00';
                $data['after_hours_number'] = 0;
            }
            
            unset($data['ahf_start_hour'],$data['ahf_start_minute'],$data['ahf_start_meridiem'],
                  $data['ahf_end_hour'],$data['ahf_end_minute'],$data['ahf_end_meridiem']);
            
            return $data;
        }
        
        static function findForwardingNumber($incoming_number){
            
            if(preg_match('/^\+1/',$incoming_number)){
                $incoming_number = substr($incoming_number,2);
            }
            
            $result = \DB::select(array('n2.number', 'forwarding_number'), array('f1.number', 'after_hours_number'), 'after_hours_forwarding', 'after_hours_start', 'after_hours_end')
                        ->from(array('ct_campaigns','c'))
                        ->join(array('ct_numbers', 'n1'))->on('n1.id', '=', 'c.incoming_number')
                        ->join(array('ct_numbers', 'n2'))->on('n2.id', '=', 'c.forwarding_number')
                        ->join(array('ct_numbers', 'f1'), 'LEFT')->on('f1.id', '=', 'c.after_hours_number')
                        ->where('n1.number', '=', $incoming_number)
                        ->where('c.active', 1)
                        ->execute();
            
            $row = current($result->as_array());
            
            if($row['after_hours_forwarding'] && strtotime($row['after_hours_start']) && strtotime($row['after_hours_end']) && (time() >= strtotime(date('Y-m-d ').$row['after_hours_start']) || time() < strtotime(date('Y-m-d ').$row['after_hours_end']))){
                return $row['after_hours_number'];
            }
            
            return $row['forwarding_number'];
        }
        
        static function findAll($offset = 0, $limit = 25){
            
            $result = \DB::select('c.id','c.name',array('n1.number', 'incoming_number'),array('n2.number','forwarding_number'), array('s.company', 'subaccount'))
                        ->from(array('ct_campaigns', 'c'))
                        ->join(array('ct_numbers', 'n1'))->on('c.incoming_number', '=', 'n1.id')
                        ->join(array('ct_numbers', 'n2'))->on('c.forwarding_number', '=', 'n2.id')
                        ->join(array('ct_subaccounts', 's'), 'LEFT')->on('c.subaccount_id', '=', 's.id')
                        ->where('c.org_id', $_SESSION['user']['org_id'])
                        ->where('c.active', '=', 1)
                        ->order_by('c.name')
                        ->limit($limit)
                        ->offset($offset)
                        ->execute();
            
            return $result->as_array();
            
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');
            
            if($factory == 'add_campaign'){
                $val->add('incoming_number', 'Incoming Number')
                    ->add_rule('required');
            }
            
            $val->add('forwarding_number', 'Forwarding Number')
                ->add_rule('required');

            return $val;
        }
        
    }