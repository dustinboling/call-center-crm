<?php

    namespace CallTracking;

    class Controller_IAPI extends Controller_Base{
        
        function action_local_numbers($area_code){
            
            if(!empty($area_code)){
                $search['AreaCode'] = $area_code;
            }
            
            $result = \Twilio::getClient()->account->available_phone_numbers->getList('US', 'Local', $search);

            $numbers = array();
            foreach($result->available_phone_numbers as $number){
                $numbers[] = array('clean' => $number->phone_number, 'formatted' => $number->friendly_name);
            }
            
            print json_encode($numbers);
            
        }
        
        function action_toll_free_numbers($area_code){
            
            if(!empty($area_code)){
                $search['Contains'] = $area_code.'*******';
            }
            
            $result = \Twilio::getClient()->account->available_phone_numbers->getList('US', 'TollFree', $search);

            $numbers = array();
            foreach($result->available_phone_numbers as $number){
                $numbers[] = array('clean' => $number->phone_number, 'formatted' => $number->friendly_name);
            }
            
            print json_encode($numbers);
            
        }
        
        function action_area_codes($state){
            
            $area_codes = Model_Campaign::get_area_codes($state);
            $codes = array();
            foreach($area_codes as $v){
                $codes[] = $v['area_code'];
            }
            
            print json_encode($codes);
            
        }
        
    }