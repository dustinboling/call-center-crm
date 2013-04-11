<?php

    class Model_User {

        static function findAll(){

            $users = array();
            $result = DB::select('id','first_name','last_name')
                        ->from('users')
                        ->where('active', 1)
                        ->execute();

            if(count($result)){
                $users = $result->as_array();
            }
            return $users;

        }
    }