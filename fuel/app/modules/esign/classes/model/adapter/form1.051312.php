<?php

    namespace ESign;

    class Model_Adapter_Form1 extends Model_Adapter_Form{
        
        static protected $form_id = 1;
        
        static function getFormFields(){
            
            $view['agents'] = \Model_System_Agent::findAll();
            return \View::factory('document/adapter_fields/form1', $view)->render();
            
        }
        
        static function processData(){
            
        }
        
    }