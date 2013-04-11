<?php

    class Format{

        static function phone($phone){

            $clean = preg_replace('/[^0-9]/','',$phone);

            if(strlen($clean) == 11){
                return '('.substr($clean, 1, 3).') '.substr($clean, 4, 3).'-'.substr($clean, 7);
            }elseif(strlen($clean) == 10){
                return '('.substr($clean, 0, 3).') '.substr($clean, 3, 3).'-'.substr($clean, 6);
            }elseif(strlen($clean) == 7){
                return substr($clean, 3, 3).'-'.substr($clean, 6);
            }else{
                return $phone;
            }

        }

        static function ssn($ssn){
            $clean = preg_replace('/[^0-9]/','',$ssn);
            return substr($clean, 0, 3).'-'.substr($clean, 3, 2).'-'.substr($clean, 5);
        }

        static function relative_date($date, $format = 'D m/d g:ia'){
            
            if(!strtotime($date)){
                return '';
            }
            
            $day = date('Y-m-d', strtotime($date));
            
            if($day == date('Y-m-d')){
                return 'Today at '.date('g:ia', strtotime($date));
            }elseif($day == date('Y-m-d', strtotime('-1 day'))){
                return 'Yesterday at '.date('g:ia', strtotime($date));
            }elseif($day == date('Y-m-d', strtotime('+1 day'))){
                return 'Tomorrow at '.date('g:ia', strtotime($date));
            }else{
                return date($format, strtotime($date));
            }
            
        }
        
        static function seconds_to_minutes($seconds){
            
            $ms = '';
        
            $hours = intval((($seconds / 60) / 60) % 60); 
            if($hours > 0){
                $ms = str_pad($hours, 2, "0", STR_PAD_LEFT). ":";
            }
            
            $minutes = intval(($seconds / 60) % 60); 
            $ms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";

            $secs = intval($seconds % 60); 
            $ms .= str_pad($secs, 2, "0", STR_PAD_LEFT);

            return $ms;
            
        }

        static function number_string($string) {
            $string = preg_replace('/[^0-9]/','', (string)$string);
            return $string;
        }
        
        static function priority_level($level){
            
            switch($level){
                case 1:
                    return '<span class="label label-important">Level 1</span>';
                case 2:
                    return '<span class="label label-warning">Level 2</span>';
                case 3:
                    return '<span class="label label-success">Level 3</span>';
                case 4:
                    return '<span class="label label-notice">Level 4</span>';
                case 5:
                    return '<span class="label">Level 5</span>';
            }
            
        }
        
        static function payment_status($id){
            
            switch($id){
                case 1:
                    return '<span class="label label-success">Current</span>';
                case 2:
                    return '<span class="label label-important">NSF</span>';
            }
            
        }

    }