<?php

    namespace ESign;

    class Model_Form extends \Model_Form{
  
        static function findESign(){
            $result = \DB::select()->from('forms')->where('esign', '=', 1)->where('active', '=', 1)->execute();
            return $result->as_array();
        }
        
    }
