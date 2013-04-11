<?php

    namespace ESign;

    class Model_Document extends \Model{
        
        static function add($data){
            \DB::insert('es_documents')->set($data)->execute();
        }
        
        static function findByCaseID($id){
            
            $result = \DB::select('d.*', array('f.name', 'form_name'))
                    ->from(array('es_documents','d'))
                    ->join(array('forms', 'f'))->on('f.id', '=', 'd.form_id')
                    ->where('case_id', '=', $id)->order_by('created','desc')->execute();
            
            $docs = array();
            foreach($result->as_array() as $row){
                $docs[$row['id']] = $row;
            }
            
            return $docs;
            
        }
        
        static function findByDocumentKey($document_key){
            
            $result = \DB::select()->from('es_documents')->where('document_key', '=', $document_key)->execute();
            return current($result->as_array());
            
        }
        
        static function update($id, $data){
            $result = \DB::update('es_documents')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function updateStatus($document_key){

            require(\PKGPATH.'echosign/bootstrap.php');
            $echosign = new \EchoSignAPI(\Config::get('api_key'));
            
            $history = $echosign->getDocumentInfo($document_key);
            
            $event = end($history->documentInfo->events->DocumentHistoryEvent);
            
            $update = array(
                            'latest_document_key' => (string)$history->documentInfo->latestDocumentKey, 
                            'last_action' => date('m/d/y g:ia', strtotime($event->date)) .': '.$event->description
                           );
            
            if($history->documentInfo->status == 'SIGNED'){
                $update['status'] = 'Signed';
                $update['final_version_key'] = (string)$history->documentInfo->latestDocumentKey;
            }
            
            $doc = self::findByDocumentKey($document_key);
            
            self::update($doc['id'], $update);
            
            $all_docs = self::findByCaseID($doc['case_id']);
            $signed = true;
            foreach($all_docs as $d){
                if($d['status'] != 'Signed'){
                    $signed = false;
                }
            }
            
            if($signed){
                \Model_Case::updateBase($doc['case_id'], array('docs_status' => 'Signed'));
            }
        }
        
    }