<?php

    namespace CallTracking;

    class Model_Number extends \Model{
        
        static function find($id){
            
            $result = \DB::select()->from('ct_numbers')->where('org_id', '=', $_SESSION['user']['org_id'])->where('id', '=', $id)->execute();
            return current($result->as_array());
            
        }
        
        static function purchase($number){
            $number = preg_replace('/[^0-9]/','',$number);
            $purchased = \Twilio::getClient()->account->incoming_phone_numbers->create(array('PhoneNumber' => '+1'.$number, 'VoiceUrl' => \Config::get('default_voice_url'), 'StatusCallback' => \Config::get('default_status_callback_url'), 'VoiceFallbackUrl' => \Config::get('fallback_voice_url')));
            self::add(array('number' => $number, 'purchased' => 1, 'twilio_id' => (string)$purchased->IncomingPhoneNumber->Sid));
        }
        
        static function cancel($number){
            \Twilio::getClient()->account->incoming_phone_numbers->delete(array('PhoneNumber' => $number));
        }
        
        static function findByType($type, $available = null){
            
            $type_id = array('internal' => 0, 'purchased' => 1);
            
            $result = \DB::select('n.id','n.label', 'n.number', array('c.name', 'campaign'), array('c.id', 'campaign_id'))
                    ->from(array('ct_numbers','n'))
                    ->join(array('ct_campaigns', 'c'),'LEFT')->on('n.id', '=', 'c.incoming_number')
                    ->where('n.org_id', '=', $_SESSION['user']['org_id'])
                    ->where('n.purchased', '=', $type_id[$type])
                    ->where('n.active', '=', 1)
                    ->order_by('c.name')
                    ->order_by('n.id');

            if($available === 1){
                $result->where('n.campaign_id', '=', 0);
            }elseif($available === 0){
                $result->where('n.campaign_id', '>', 0);
            }
            
            $result = $result->execute();
            return $result->as_array();
            
        } 
        
        static function add($data){
            
            $data['org_id'] = $_SESSION['user']['org_id'];
            $data['number'] = preg_replace('/[^0-9]/','',$data['number']);
            $data['created'] = date('Y-m-d H:i:s');
            $data['created_by'] = $_SESSION['user']['id'];

            list($insert_id, $rows_affected) = \DB::insert('ct_numbers')->set($data)->execute();
            return $insert_id;
            
        }
        
        static function update($id, $data){
            
            \DB::update('ct_numbers')->set($data)->where('org_id', '=', $_SESSION['user']['org_id'])->where('id', '=', $id)->execute();

        }
        
        static function delete($id){
            
            \DB::update('ct_numbers')->set(array('active' => 0))->where('org_id', '=', $_SESSION['user']['org_id'])->where('id', '=', $id)->execute();

        }
                
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('label', 'Label')
                ->add_rule('required');

            if($factory == 'add_number'){
                $val->add('number', 'Number')
                    ->add_rule('required');
            }

            return $val;
        }
        
    }