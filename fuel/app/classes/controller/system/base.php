<?php

    class Controller_System_Base extends Controller_Base{
        
        function before(){
            
            parent::before();
            
            if(Model_Account::getType() != 'Admin'){
                Response::redirect('/');
            }
            
        }
    }