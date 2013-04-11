<?php

    class Model_Role {

        static function findAll(){
            $roles = array();
            $sql = "SELECT  *,
                    FROM roles";
            $result = DB::query($sql, DB::SELECT)->execute();
            if (count($result)) {
                $roles = $result->as_array();
            }
            return $roles;
        }

        static function accessRoles($role_array) {
            $roles = array();
            $roles = implode(',', $role_array);
            $sql = "SELECT * FROM roles WHERE id IN ($roles)";
            $result = DB::query($sql, DB::SELECT)->execute();
            if (count($result)) {
                $roles = $result->as_array();
            }
            return $roles;
        }
    }