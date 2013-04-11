<?php

    class Model_Access {

        static function access($role_id){
            $access_array = array(
                2 => array(2),
                3 => array(2,3,4),
                4 => array(4),
            );
            if ($role_id == 1) {
                $super = array_keys($access_array);
                $super[] = 1;
                return $super;
            }
            if (isset($access_array[$role_id])) {
                return $access_array[$role_id];
            }
            //throw new \Exception('Could not identify the role');
        }
    }