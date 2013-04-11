<?php
    
    class Model_System_Object extends Model{
        
        static function find($id){
            
            $result = DB::select()->from('objects')->where('id', '=', $id)->execute();
            return current($result->as_array());
            
        } 
        
    }