<?php

    class Twilio{
        
        protected static $client;
        
        private function __construct(){ /*singleton*/ }
        
        static function init($account_sid, $auth_token){
            require PKGPATH.'Twilio/Services/Twilio.php';
            self::$client = new Services_Twilio($account_sid, $auth_token);
        }
        
        static function getClient(){
            return self::$client;
        }
        
    }