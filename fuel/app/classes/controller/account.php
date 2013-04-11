<?php

    class Controller_Account extends Controller_Base{
        
        function action_signin(){
            
            if($_POST){

                try{
                    Model_Account::signIn($_POST['email'], $_POST['passwd']);
                    if(isset($_SESSION['redirect_after_login']) && !empty($_SESSION['redirect_after_login'])){
                        header('location:'. $_SESSION['redirect_after_login']);
                        exit;
                    }else{
                        Response::redirect('dashboard');
                    }
                }catch(Exception $e){
                    Notify::error($e);
                }
            }
            
            $this->response->body = View::factory('login');
        }
        
        function action_signout(){
            Model_Account::signOut();
            Response::redirect('account/signin');
        }

        function action_test() {
            print 'hello';
        }
        
    }