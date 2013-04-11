<?php

    class Controller_Event extends Controller_Base{
        
        function action_popups(){
            
            $popups = Model_Event::getPopups();
            print json_encode($popups);
            
        }
        
        function action_record_popup($id){
            Model_Event::completeReminderPopup($id);
        }
        
    }