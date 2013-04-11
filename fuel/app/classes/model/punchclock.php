<?php

    class Model_Punchclock {

        static function find($punch_id) {
            $sql = "SELECT
                        p.*,
                        u.first_name,
                        u.last_name
                    FROM application_punch_clock p
                    JOIN users u ON p.user_id = u.id
                    WHERE p.id = $punch_id";
            $result = DB::query($sql, DB::SELECT)->execute();

            if (count($result)) {
                $punch = $result->as_array();
                return $punch[0];
            }
            return array();
        }

        static function findApplicationPunches($application_id) {
            $sql = "SELECT
                        p.*,
                        u.first_name,
                        u.last_name
                    FROM application_punch_clock p
                    JOIN users u ON p.user_id = u.id
                    WHERE p.application_id = $application_id
                    ORDER BY p.in_time DESC";
            $result = DB::query($sql, DB::SELECT)->execute();

            if (count($result)) {
                return $result->as_array();
            }
            return array();
        }

        static function findTimeOnApplications($application_ids) {
            $app_ids = implode(',', $application_ids);
            $values = array();
            $sql = "SELECT *
                    FROM application_punch_clock p
                    JOIN users u ON p.user_id = u.id
                    WHERE application_id IN ($app_ids)";
            $result = DB::query($sql, DB::SELECT)->execute();

            if (count($result)) {
                foreach ($result->as_array() as $v) {
                    if (!isset($values[$v['application_id']])) {
                        $values[$v['application_id']] = $v['punchtime'];
                    } else {
                        $values[$v['application_id']] = $values[$v['application_id']] + $v['punchtime'];
                    }
                }
            }
            return $values;
        }

        static function findOpenPunches($application_id) {
            $sql = "SELECT
                        p.*,
                        u.first_name,
                        u.last_name
                    FROM application_punch_clock p
                    JOIN users u ON p.user_id = u.id
                    WHERE p.application_id = $application_id
                    AND p.out_time IS NULL
                    ORDER BY p.in_time DESC";
            $result = DB::query($sql, DB::SELECT)->execute();

            if (count($result)) {
                return $result->as_array();
            }
            return array();
        }

        static function findOpenUserPunches($user_id) {
            $sql = "SELECT
                        p.*,
                        u.first_name,
                        u.last_name
                    FROM application_punch_clock p
                    JOIN users u ON p.user_id = u.id
                    WHERE p.user_id = $user_id
                    AND p.out_time IS NULL
                    ORDER BY p.in_time DESC";
            $result = DB::query($sql, DB::SELECT)->execute();

            if (count($result)) {
                return $result->as_array();
            }
            return array();
        }

        static function findLastOpenPunch($user_id) {
            $sql = "SELECT p.*, u.first_name, u.last_name
                    FROM application_punch_clock p
                    JOIN users u ON p.user_id = u.id
                    WHERE p.user_id = $user_id
                    AND p.out_time IS NULL
                    ORDER BY p.in_time DESC
                    LIMIT 0, 1";
            $result = DB::query($sql, DB::SELECT)->execute();

            if (count($result)) {
                $punch = $result->as_array();
                return $punch[0];
            }
            return array();
        }

        static function insertPunch($values) {
            list($insert_id, $rows_affected) = \DB::insert('application_punch_clock')->set($values)->execute();
            return $insert_id;
        }

        static function updatePunch($values) {
            $id = $values['id'];
            unset($values['id']);

            $result = DB::update('application_punch_clock')
                        ->set($values)
                        ->where('id', '=', $id)
                        ->execute();
            return true;
        }

        static function punchIn($application_id, $user_id) {
            $punch_values = array(
                'application_id' => $application_id,
                'user_id' => $user_id,
                'in_time' => date('Y-m-d H:i:s'),
                'notified' => 1
            );
            return self::insertPunch($punch_values);
        }

        static function punchOut($punch_id) {

            $sql = "SELECT *
                    FROM application_punch_clock
                    WHERE id = $punch_id";
            $result = DB::query($sql, DB::SELECT)->execute();
            if (count($result)) {
                $punches = $result->as_array();
                $punch = $punches[0];
                if (strlen($punch['out_time'])) {
                    return false;
                }
                $now = date('Y-m-d H:i:s');
                $in = strtotime($punch['in_time']);
                $out = strtotime($now);
                $punchtime = $out - $in;
                $punch['out_time'] = $now;
                $punch['punchtime'] = $punchtime;
                if (self::updatePunch($punch)) {
                    return true;
                }
                return false;
            }
            return false;
        }

        static function deletePunch($id) {
            $result = DB::delete('application_punch_clock')
                        ->where('id', '=', $id)
                        ->execute();
            return true;
        }
    }