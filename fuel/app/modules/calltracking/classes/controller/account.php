<?php

    namespace CallTracking;

    class Controller_Account extends Controller_Base{
        
        function action_signin(){
            
            if($_POST){
                try{
                    Model_Account::signIn($_POST['email'], $_POST['passwd']);
                    \Response::redirect('/calltracking/dashboard');
                }catch(Exception $e){
                    \Notify::error($e);
                }
            }
            
            $this->response->body = \View::factory('login');
        }
        
        function action_signout(){
            Model_Account::signOut();
            \Response::redirect('account/signin');
        }
        
    }