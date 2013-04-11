<?php

    class Controller_Document extends Controller{
        
        function action_view($id){
            
            $doc = Model_Document::find($id);
            $file = Config::get('docs_folder').$doc['case_id'].'/'.$doc['file'];
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            
            readfile($file);
            
        }
        
        function action_delete($id){
            
            Model_Document::delete($id);
            //Response::redirect($_SERVER['HTTP_REFERER']);
            
        }
        
    }