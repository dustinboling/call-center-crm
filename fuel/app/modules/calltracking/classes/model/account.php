<?php

    namespace CallTracking;

    class Model_Account {
        
        static function signIn($email, $password){
            
            $email = DB::escape($email);
            $passwd = sha1($password);
            
            $sql = "
                    SELECT      id,
                                role_id,
                                first_name,
                                last_name
                    FROM        users
                    WHERE       email = {$email}
                    AND         passwd = '{$passwd}'
                    AND         active = 1
                   ";
            
            $result = DB::query($sql, DB::SELECT)->execute();
            
            if(count($result)){
                $user = current($result->as_array());
                $_SESSION['user'] = $user;
                return;
            }
            
            throw New Exception('Login Failed');
            
        }
        
        static function subAccountSignIn($email, $password){
            
            $result = DB::select('id', 'org_id', 'email', 'first_name','last_name')
                    ->from('ct_subaccounts')
                    ->where('email', '=', $email)
                    ->where('passwd', '=', $passwd)
                    ->execute();
                    
            if(count($result)){
                
            }  
            
            throw new Exception('Login Failed');
            
            
        }
        
        static function signOut(){
            unset($_SESSION['user']);
            session_destroy();
        }
        
        static function isLoggedIn(){
            
            //allow users to use the login system without being logged in
            if(\Uri::string() == 'account/signin'){
                return true;
            }
            
            if (isset($_SESSION['user']['id']) && $_SESSION['user']['id']) {
                return true;
            }
            return false;
        }
        
    }