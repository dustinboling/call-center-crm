<?php

    class Controller_System_Case extends Controller_System_Base{
        
        function action_export(){
            
            if(!empty($_POST)){
                ini_set('memory_limit', '256M');
                Model_Case::export($_POST);
                exit;
            }
            
            $data['statuses'] = Model_System_Status::findAll(1);
            $data['campaigns'] = Model_System_Campaign::findAll();
            $data['fgroups'] = Model_System_ObjectFields::findAllGroups();
            $data['fields'] = Model_System_ObjectFields::findAllGrouped(1);
            $this->response->body = View::factory('layout', array('l' => 'system/case/export', 'c' => $data));
            
        }
        
        function action_import(){
            
            if(!empty($_POST)){
                
                if(!isset($_POST['file']) && !empty($_FILES)){
                    
                    if(substr($_FILES['import_file']['name'],-4) != ".csv"){
                        
                        notify::error('Uploaded file must be in .csv format');
                      
                    }else{
                        
                        //TODO move this path to config
                        $import_file_path = '/var/www/crm/import/';
                        $import_file = date('YmdHis').'/import.csv';

                        mkdir($import_file_path.str_replace('/import.csv', '', $import_file), 0777, true);
                        move_uploaded_file($_FILES['import_file']['tmp_name'], $import_file_path.$import_file);

                        $handle = fopen($import_file_path.$import_file, 'r');
                        $line = fgetcsv($handle);
                        fclose($handle);

                        $data['cols'] = $line;
                        $data['import_file'] = $import_file;
                        $data['fields'] = $_POST['ds'];
                        $data['campaigns'] = Model_System_Campaign::findAll();
                        return $this->response->body = View::factory('layout', array('l' => 'system/case/map_import', 'c' => $data));
                        
                    }
                } elseif(isset($_POST['import_file'])){

                    Model_Case::fileImport($_POST);
                    
                }
                
                
            }
            
            $data['fgroups'] = Model_System_ObjectFields::findAllGroups();
            $data['fields'] = Model_System_ObjectFields::findAllGrouped(1);
            $this->response->body = View::factory('layout', array('l' => 'system/case/import', 'c' => $data));
            
        }
                
    }