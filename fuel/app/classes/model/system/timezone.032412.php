<?php

    class Model_System_Timezone extends Model{
        
        static function findByAreaCode($area_code){
            
            $result = DB::select('timezone')->from('lookup_timezones')->where('area_code', '=', $area_code)->execute();
            $tz = current($result->as_array());
            return $tz['timezone'];
            
        }
        
    }