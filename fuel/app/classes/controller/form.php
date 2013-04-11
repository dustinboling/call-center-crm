<?php
    
    class Controller_Form extends Controller_Base{
        
        
        function action_download($form_id, $case_id){
            
            $file = Model_Form::generate($form_id, $case_id);
            $filename = substr($file, strrpos($file,'/')+1);;
            
            header('Content-type: application/pdf');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header("Cache-Control: no-cache, must-revalidate"); 
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
            readfile($file);
            
        }

    }