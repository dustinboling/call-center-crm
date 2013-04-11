<?php

    class DateRange{
        
        static function today(){
            return array(new DateTime('midnight'), new DateTime('tomorrow midnight'));
        }
        
        static function yesterday(){
            return array(new DateTime('midnight yesterday'), new DateTime('midnight'));
        }
        
        static function tomorrow(){
            return array(new DateTime('midnight tomorrow'), new DateTime('midnight + 2 days'));
        }
        
        static function thisWeek(){
            return array(new DateTime('midnight last monday'), new DateTime('midnight monday'));
        }
        
        static function lastWeek(){
            return array(new DateTime('midnight -2 monday'), new DateTime('midnight last monday'));
        }      
        
        static function nextWeek(){
            return array(new DateTime('midnight next monday'), new DateTime('midnight +2 monday'));
        }      
        
        static function thisMonth(){
            return array(new DateTime('midnight first day of'), new DateTime('midnight first day of next month'));
        }
        
        static function lastMonth(){
            return array(new DateTime('midnight first day of last month'), new DateTime('midnight first day of'));
        }      
        
        static function nextMonth(){
            return array(new DateTime('midnight first day of next month'), new DateTime('midnight first day of +2 month'));
        }
        
        static function get($string){
            $method = strtolower(str_replace(' ','',ucwords(str_replace('_',' ',$string))));
            if(is_callable('self::'.$method)){
                return call_user_func('self::'.$method);
            }
            throw new Exception('Unknown method '.$string);
        }
        
        static function describe($string){
            return ucwords(str_replace('_',' ',$string));
        }
    }
