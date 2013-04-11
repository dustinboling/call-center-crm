<?php

    class Controller_Base extends Controller{
        
        protected $offset = 0;
        protected $limit = 25;
        
        function before(){
            session_start();
            
            define("OBJECT_CLIENT", 1);

            if(!Model_Account::isLoggedIn()){
                if(uri::segment(2) != 'popups'){
                    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
                }
                Response::redirect('account/signin');
            }
            $_SESSION['user']['org_id'] = 1;
            //dev
            //Twilio::init('AC8fdb55987efb13726f882ff61c0c6d9d', 'e2f214fc32fa91a5d473fc20800b2ba5');
            //live
            //Twilio::init('ACdce6be902f7ebc743efebeee15e25e91', 'db7237d1b72ce04f0492f6db170311cf');
            
            if(isset($_GET['limit'])){
                $this->limit = $_GET['limit'];
            }
            
            if(isset($_GET['page'])){
                $this->offset = ($_GET['page']-1) * $this->limit;
            }

        }
        
    }