<?php

    namespace ESign;

    class Model_Document extends \Model{
        
        static function findByAppID($id){
            
            $result = \DB::select()->from('es_documents')->where('app_id', '=', $id)->execute();
            
            $docs = array();
            foreach($result->as_array() as $row){
                $docs[$row['id']] = $row;
            }
            
            return $docs;
            
        }
        
    }