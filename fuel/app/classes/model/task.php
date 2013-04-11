<?php

    class Model_Task {

        // APPLICATIONS

        static function findApplicationTasks($application_id) {

            $user_id = $_SESSION['user']['id'];
            $role_id = $_SESSION['user']['role_id'];
            $access = Model_Access::access($role_id);
            $access_imp = implode(',', $access);

            $sql = "SELECT  t.*,
                            au.first_name as assignee_fname,
                            au.last_name as assignee_lname,
                            cu.first_name as created_fname,
                            cu.last_name as created_lname,
                            uu.first_name as updated_fname,
                            uu.last_name as updated_lname,
                            compu.first_name as completed_fname,
                            compu.last_name as completed_lname
                    FROM tasks t
                    LEFT JOIN task_visibility tv ON t.id = tv.task_id
                    LEFT JOIN users au ON t.assignee = au.id
                    LEFT JOIN users cu ON t.creator = cu.id
                    LEFT JOIN users uu ON t.updater = uu.id
                    LEFT JOIN users compu ON t.completer = compu.id
                    WHERE t.application_id = $application_id
                    AND ((t.assignee = $user_id) OR (tv.user_id = $user_id))";
            /* OR (tv.role_id IN ($access_imp)) */
            $result = DB::query($sql, DB::SELECT)->execute();

            if (count($result)) {
                $out = array();
                foreach($result->as_array() as $t) {
                    $out[$t['id']] = $t;
                    if ($t['assignee'] == $user_id) {
                        $out[$t['id']]['access'] = 'assignee';
                    } else {
                        $out[$t['id']]['access'] = 'shared';
                    }
                }
                return $out;
            }

            return array();
        }

        static function findTask($id) {
            $sql = "SELECT  t.*,
                            tv.role_id,
                            tv.user_id,
                            au.first_name as assignee_fname,
                            au.last_name as assignee_lname,
                            cu.first_name as created_fname,
                            cu.last_name as created_lname,
                            uu.first_name as updated_fname,
                            uu.last_name as updated_lname,
                            compu.first_name as completed_fname,
                            compu.last_name as completed_lname
                    FROM tasks t
                    LEFT JOIN task_visibility tv ON t.id = tv.task_id
                    LEFT JOIN users au ON t.assignee = au.id
                    LEFT JOIN users cu ON t.creator = cu.id
                    LEFT JOIN users uu ON t.updater = uu.id
                    LEFT JOIN users compu ON t.completer = compu.id
                    WHERE t.id = $id";

            $result = DB::query($sql, DB::SELECT)->execute();

            if (count($result)) {
                $out = array();
                $roles = array();
                $users = array();
                foreach($result->as_array() as $t) {
                    if (!is_null($t['role_id']) && $t['role_id']) {
                        $roles[] = $t['role_id'];
                    }
                    if (!is_null($t['user_id']) && $t['user_id']) {
                        $users[] = $t['user_id'];
                    }
                    unset($t['role_id']);
                    unset($t['user_id']);
                    $out[$t['id']] = $t;
                }
                $out[$id]['visibility']['roles'] = array_unique($roles);
                $out[$id]['visibility']['users'] = array_unique($users);
                return $out[$id];
            }
            throw new Exception('Could not find the requested task.');
        }

        static function insertTask($values) {
            list($insert_id, $rows_affected) = \DB::insert('tasks')->set($values)->execute();
            return $insert_id;
        }

        static function insertTaskVisibility($values) {
            \DB::insert('task_visibility')->set($values)->execute();
            return true;
        }

        static function deleteTaskVisibility($task_id) {
            $result = DB::delete('task_visibility')
                        ->where('task_id', '=', $task_id)
                        ->execute();
            return true;
        }

        static function updateTask($values) {
            $id = $values['id'];
            unset($values['id']);

            $result = DB::update('tasks')
                        ->set($values)
                        ->where('id', '=', $id)
                        ->execute();
            return true;
        }

        static function deleteTask($id) {
            $result = DB::delete('tasks')
                        ->where('id', '=', $id)
                        ->execute();
            return true;
        }
    }