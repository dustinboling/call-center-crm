<?php
    
    class Model_Import extends Model{
        
        protected static $errors;
        protected static $campaigns;
        protected static $statuses;
        protected static $timezones;
        protected static $users;
        protected static $users_last;
        
        static function getErrors(){
            return self::$errors;
        }
        
        static function preloadLookups(){
            
            $campaigns = Model_System_Campaign::findAll();
            foreach($campaigns as $c){
                self::$campaigns[$c['id']] = $c['name']; 
            }
            
            $statuses = Model_System_Status::findAll(1);
            foreach($statuses as $s){
                self::$statuses[$s['id']] = $s['name'];
            }
            
            $timezones = Model_System_Timezone::findAll();
            foreach($timezones as $t){
                self::$timezones[$t['area_code']] = $t['timezone'];
            }

            $users = Model_User::findAll();
            foreach ($users as $u) {
                self::$users[$u['id']] = trim($u['first_name']).' '.trim($u['last_name']);
                self::$users_last[$u['id']] = trim($u['last_name']).', '.trim($u['first_name']);
            } 

        }
        
        static function findRepByName($name){
            
            if(empty(self::$users)){
                self::preloadLookups();
            }
            
            $name = trim(str_replace(array('( NOT A REP)','(NOT A REP)'),'',$name));
            $name = preg_replace('/\s+/',' ', $name);
            $id = array_search($name, self::$users_last);
            
            if($id){
               return $id; 
            }
            
            $id = array_search($name, self::$users);
            
            if($id){
               return $id; 
            }
            
            print '<p>No Match: '.$name.'</p>';
            return 0;
        }

        static function paymentImport($data) {
            if (isset($data['creator'])) {
                // find name
                // if can't find name, self::errors
                unset($data['creator']);
            }
            if (isset($data['updated'])) {
                // find name
                // if can't find name, self::errors
                unset($data['updater']);
            }
            \DB::insert('payments')->set($data)->execute();
            return true;
        }

        static function activityImport($data) {

            self::preloadLookups();
            $system_user = 0;
            $system = array('Leads360 System', 'Post System');
/*
            //set the campaign id if you can find it
            if (isset($data['campaign'])) {
                
                $campaign_id = array_search($data['campaign'], self::$campaigns);
                if(!$campaign_id){
                    self::$errors[] = array('number' => $data['primary_phone'], 'message' => 'Could not find Campaign ID');
                    $data['campaign_id'] = 0;
                }else{
                    $data['campaign_id'] = $campaign_id;
                }
                unset($data['campaign']);
            }
*/
            //set the user id if you can find it
            if (isset($data['user'])) {

                if (in_array(trim($data['user']), $system)) {
                    $data['by'] = $system_user;
                } else {
                    $data['by'] = self::findRepByName($data['user']);
                }
                unset($data['user']);
            }
            \DB::insert('log_activity')->set($data)->execute();
            return true;
        }
        
        static function caseImport($data){
            
            if(empty($data)){
                self::$errors[] = array('number' => '', 'message' => 'Encountered empty record');
            }
            
            if(empty(self::$timezones)){
                self::preloadLookups();
            }
            
            //set the status to new if one doesn't exist
            if(self::noValue($data, 'status')){ $data['status'] = 'New'; }
            
            //set the created date to now if created doesn't exist or isn't parsable
            if(self::noValue($data, 'created') || !strtotime($data['created'])){
                $base = array('created' => date('Y-m-d H:i:s'));
                $data['created'] = $base['created'];
            }else{
                $base = array('created' => date('Y-m-d H:i:s', strtotime($data['created'])));
            }
            
            //use the leads360 id as the id field if it exists             
            if(!self::noValue($data, 'leads360_id')){
                $base['id'] = $data['leads360_id'];
            }
            
            if(!empty($data['sales_rep'])){
                $base['sales_rep_id'] = self::findRepByName($data['sales_rep']);
                unset($data['sales_rep']);
            }

//            //set the sale rep id if you can find it
//            if(isset($data['sales_rep'])) {
//                if (strlen($data['sales_rep'])) {
//                    $user_set = array();
//                    if (strpos($data['sales_rep'], ',')) {
//                        $user_set = self::$users_last;
//                    } else {
//                        $user_set = self::$users;
//                    }
//                    $sales_rep_id = array_search($data['sales_rep'], $user_set);
//                    if(!$sales_rep_id){
//                        self::$errors[] = array('number' => $data['primary_phone'], 'message' => 'Could not find the sales rep user');
//                    } else {
//                        $data['sales_rep_id'] = $sales_rep_id;
//                    }
//                }
//                unset($data['sales_rep']);
//            }
//
//            //set the closer rep id if you can find it
//            if(isset($data['closer_rep'])) {
//                if (strlen($data['closer_rep'])) {
//                    $user_set = array();
//                    if (strpos($data['closer_rep'], ',')) {
//                        $user_set = self::$users_last;
//                    } else {
//                        $user_set = self::$users;
//                    }
//                    $closer_rep_id = array_search($data['closer_rep'], $user_set);
//                    if(!$closer_rep_id){
//                        self::$errors[] = array('number' => $data['primary_phone'], 'message' => 'Could not find the closer rep user');
//                    } else {
//                        $data['closer_rep_id'] = $closer_rep_id;
//                    }
//                }
//                unset($data['closer_rep']);
//            }
//
//echo '<p>';
//echo '<pre>';
//print_r($data);
//echo '</pre>';
//echo '</p>';
//            exit;
            
            //set the campaign id if you can find it
            if(isset($data['campaign'])){
                
                $campaign_id = array_search($data['campaign'], self::$campaigns);
                if(!$campaign_id){
                    if(!empty($data['campaign'])){
                        $data['campaign'] = '(!) '.$data['campaign'];
                    }
                    self::$errors[] = array('number' => $data['primary_phone'], 'message' => 'Could not find Campaign ID');
                }else{
                    $data['campaign_id'] = $campaign_id;
                    $base['campaign_id'] = $campaign_id;
                }
 
            }else{
                $data['campaign'] = '';
            }
            
            //set the status id if you can find it
            if(isset($data['status'])){
                
                $status_id = array_search($data['status'], self::$statuses);
                if(!$status_id){
                    if(!empty($data['status'])){
                        $data['status'] = '(!) '.$data['status'];
                    }
                    self::$errors[] = array('number' => $data['primary_phone'], 'message' => 'Could not find Status ID');
                }else{
                    $data['status_id'] = $status_id;
                    $base['status_id'] = $status_id;
                }

            }else{
                $data['status'] = '';
            }

            try{
                $result = DB::insert('cases')->set($base)->execute();
                $case_id = current($result);
            }catch(Exception $e){
                self::$errors[] = array('number' => $data['primary_phone'], 'message' => 'Database insert failed');
                return;
            }
            
            if(empty($case_id)){
                self::$errors[] = array('number' => $data['primary_phone'], 'message' => 'Database insert failed');
            }
            
            $data['_id'] = $data['id'] = (int)$case_id;
            
            if(!self::noValue($data, 'first_name')){
                $data['search_first_name'] = strtolower($data['first_name']);
            }
            
            if(!self::noValue($data, 'last_name')){
                $data['search_last_name'] = strtolower($data['last_name']);
            }
            
            if(!self::noValue($data, 'first_name') && !self::noValue($data, 'last_name')){
                $data['search_name'] = $data['search_first_name'] . ' ' . $data['search_last_name'];
            }
            
            if(!self::noValue($data, 'primary_phone')){
                $area_code = substr(preg_replace('/[^0-9]/','', $data['primary_phone']), 0, 3);
                if(isset(self::$timezones[$area_code])){
                    $data['timezone'] = self::$timezones[$area_code];
                }else{
                    self::$errors[] = array('number' => $data['primary_phone'], 'message' => 'Could not set timezone');
                }
                
            }else{
                self::$errors[] = array('number' => $data['primary_phone'], 'message' => 'No primary phone set');
            }
            
            $mdb = Mongo_Db::instance();
            try{
                $insert_id = $mdb->insert('cases', $data);
            }catch(Exception $e){
                self::$errors[] = array('number' => $data['primary_phone'], 'message' => $e->getMessage());
            }
            
            if(!$insert_id){
                self::$errors[] = array('number' => $data['primary_phone'], 'message' => 'Mongo insert failed');
            }
            
            return $case_id;
            
        }
        
        static function noValue($case, $property){
            if(!isset($case[$property]) || empty($case[$property])){
                return true;
            }

            return false;
        }
        
    }