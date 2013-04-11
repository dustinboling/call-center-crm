<?php

    class Model_Document extends Model{
        
        static function find($id){
            
            $result = DB::select()->from('case_documents')->where('id', '=', $id)->execute();
            return current($result->as_array());
            
        }
        
        static function findByCaseID($case_id){
            
            $result = DB::select()->from('case_documents')->where('case_id', '=', $case_id)->order_by('id', 'desc')->execute();
            return $result->as_array();
            
        }
        
        static function add($case_id, $file){

            $folder = Config::get('docs_folder').$case_id.'/';
            
            if(!is_dir($folder)){
                mkdir($folder);
            }
            
            $filename = str_replace(' ', '-', preg_replace('/\s+/', ' ', preg_replace('/[^a-z0-9\.\_ ]/i', '', $file['name'][0])));                
            move_uploaded_file($file['tmp_name'][0], $folder.$filename);
            
            $data = array(
                            'case_id' => $case_id,
                            'name' => $file['name'][0],
                            'file' => $filename,
                            'created_by' => $_SESSION['user']['id'],
                            'created_date' => date('Y-m-d H:i:s')
                         );

            $result = DB::insert('case_documents')->set($data)->execute();
            
            $data['id'] = $result[0];
            $data['created_date'] = format::relative_date($data['created_date']);
            
            return $data;
            
        }
        
        static function delete($id){
            
            DB::delete('case_documents')->where('id', '=', $id)->execute();
            
        }
        
    }