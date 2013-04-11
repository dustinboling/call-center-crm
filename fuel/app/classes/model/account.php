<?php

    class Model_Account {
        
        static function signIn($email, $password){
            
            $passwd = sha1($password);
                             
            $result = DB::select('id','first_name','last_name','type')
                        ->from('users')
                        ->where('email', $email)
                        ->where('passwd', $passwd)
                        ->where('active', 1)
                        ->execute();        

            if(count($result)){
                $user = current($result->as_array());
                $_SESSION['user'] = $user;
                return;
            }
            
            throw New Exception('Login Failed');
            
        }
        
        static function signOut(){
            unset($_SESSION['user']);
            session_destroy();
        }
        
        static function isLoggedIn(){
            
            //allow users to use the login system without being logged in
            if(Uri::string() == 'account/signin'){
                return true;
            }
            
            if (isset($_SESSION['user']['id']) && $_SESSION['user']['id']) {
                return true;
            }
            return false;
        }
        
        static function getType(){
            if(!isset($_SESSION['user']['type'])){
                self::signOut();
            }
            return $_SESSION['user']['type'];
        }
        
    }