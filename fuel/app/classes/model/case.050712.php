<?php

    class Model_Case extends Model{
        
        static protected $last_result_count;
        
        static function findAll($offset = 0, $limit = 100, $sort_field = 'created', $order = 'desc'){
            
            $result = DB::select('c.*', array('s.name', 'status'), array(DB::expr('CONCAT(u.first_name, " ", u.last_name)'), 'sales_rep_name'))
                    ->from(array('cases','c'))
                    ->where('is_duplicate', '=', 0)
                    ->join(array('statuses','s'), 'LEFT')->on('s.id', '=', 'c.status_id')
                    ->join(array('users','u'), 'LEFT')->on('u.id', '=', 'c.sales_rep_id')
                    ->offset($offset)
                    ->limit($limit)
                    ->order_by($sort_field, $order);
            
            if(Model_Account::getType() == 'User'){
                $result->where('sales_rep_id', '=', $_SESSION['user']['id']);
            }
            
            $result = self::setCriteria($result);
            
            $result = $result->execute();
            
            return self::buildResult($result);
            
        }
        
        static function findByFilter($filter, $offset = 0, $limit = 100, $sort_field = 'created', $order = 'desc', $count_only = false){
            
            if(!$count_only){
                $query = DB::select('c.*', array(DB::expr('CONCAT(u.first_name, " ", u.last_name)'), 'sales_rep_name'))->from(array('cases','c'))->join(array('users','u'), 'LEFT')->on('u.id', '=', 'c.sales_rep_id');
            }else{
                $query = DB::select(DB::expr('count(id) as total_records'))->from(array('cases','c'));
            }
            
            if(isset($filter['campaign_id']) && !empty($filter['campaign_id'])){
                $query->where('campaign_id', '=', $filter['campaign_id']);
            }
            
            if((isset($filter['status_id']) && !empty($filter['status_id'])) || (isset($filter['status_id']) && $filter['status_id'] === '0')){
                $query->where('status_id', '=', $filter['status_id']);
            }
            
            if(!empty($filter['dates']) && $filter['dates'] != 'all_time'){
                if($filter['dates'] == 'today'){
                    $query->where($filter['date_field'], 'between', array(date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')));
                }elseif($filter['dates'] == 'yesterday'){
                    $yest = date('Y-m-d', strtotime('-1 day'));
                    $query->where($filter['date_field'], 'between', array($yest.' 00:00:00', $yest.' 23:59:59'));
                }elseif($filter['dates'] == 'last7'){
                    $query->where($filter['date_field'], '>', date('Y-m-d', strtotime('-7 days')));
                }elseif($filter['dates'] == 'last30'){
                    $query->where($filter['date_field'], '>', date('Y-m-d', strtotime('-30 days')));
                }elseif($filter['dates'] == 'this_month'){
                    $query->where($filter['date_field'], 'between', array(date('Y-m-').'01', date('Y-m-d H:59:59')));
                }elseif($filter['dates'] == 'last_month'){
                    $query->where($filter['date_field'], 'between', array(date('Y-m-', strtotime('-1 month')).'01', date('Y-m-t 23:59:59', strtotime('-1 month'))));
                }elseif($filter['dates'] == 'custom'){
                    $query->where($filter['date_field'], 'between', array(date('Y-m-d', strtotime($filter['start_date'])), date('Y-m-d', strtotime($filter['end_date'])).' 23:59:59'));
                }
            }
            
            if(!empty($filter['user_id'])){
                $query->where('sales_rep_id', '=', $filter['user_id']);
            }
            
            if(Model_Account::getType() == 'User'){
                $query->where('sales_rep_id', '=', $_SESSION['user']['id']);
            }
            
            if(!$count_only){
                $query->offset($offset)->limit($limit)
                      ->order_by($sort_field, $order);
            }else{
                $result = $query->where('is_duplicate', '=', 0)->execute();
                $row = current($result->as_array());
                return $row['total_records'];
            }
            
            $query = self::setCriteria($query);
            
            $result = $query->execute();
            
            return self::buildResult($result);
            
        }
        
        static function getLastResultCount(){
            return self::$last_result_count;
        }
        
        static function search($query){
            
            $phone_query = preg_replace('/[^0-9]/','', $query);
            $query = strtolower($query);
            
            $mdb = Mongo_Db::instance();
            
            if(!empty($phone_query)){
                $mdb->or_where(array('_id' => (int)$query, 'leads360_id' => (int)$query, 'primary_phone' => $phone_query, 'secondary_phone' => $phone_query, 'mobile_phone' => $phone_query));
            }else{
                $mdb->or_where(array('search_first_name' => $query, 'search_last_name' => $query, 'search_name' => $query));
            }
                        
            $result = $mdb->get('cases');
            
            self::$last_result_count = $mdb->count('cases');
            
            return self::buildResultFromMongo($result);
        }
        
        static function quickSearch($query){
            
            $query = preg_replace('/[^0-9]/','', $query);

            if(empty($query)){
                throw new Exception('This search only works with the Lead ID or a Phone Number');
            }

            $mdb = Mongo_Db::instance();
            $mdb->or_where(array('_id' => (int)$query, 'primary_phone' => $query, 'secondary_phone' => $query, 'mobile_phone' => $query));
            
            $result = $mdb->get('cases');
            
            if(count($result)){
                $row = current($result);
                return $row['_id'];
            }else{
                throw new Exception('No results for: '.$query);
            }
            
        }
        
        static function countItems(){
            
            $result = DB::select(DB::expr('count(id) as items'))->from(array('cases','c'))->where('is_duplicate', '=', 0);
            
            if(Model_Account::getType() == 'User'){
                $result->where('sales_rep_id', '=', $_SESSION['user']['id']);
            }
            
            $result = self::setCriteria($result);
            $result = $result->execute();
            $row = current($result->as_array());
            return $row['items'];
            
        }
        
        static function setCriteria($result){
            return $result->where('c.is_duplicate','=',0);
        }
        
        static function find($id){
            
            $result = DB::select('c.*', array('s.name', 'status'))->from(array('cases','c'))->join(array('statuses','s'), 'LEFT')->on('s.id', '=', 'c.status_id')->where('c.id', '=', $id)->execute();
            return current(self::buildResult($result));
            
        }
        
        static function findByIDs($ids){
            
            if(!is_array($ids)){
                $ids = array($ids);
            }
            
            $result = DB::select('c.*', array('s.name', 'status'))->from(array('cases','c'))->join(array('statuses','s'), 'LEFT')->on('s.id', '=', 'c.status_id')->where('c.id', 'in', $ids)->execute();
            return self::buildResult($result);
            
        }
        
        static function findBaseData($ids){
            
            foreach($ids as $k => $v){
                $ids[$k] = (int)$v;
            }
            
            $mdb = Mongo_Db::instance();
            $mdb->select(array('first_name', 'last_name', 'status', 'campaign', 'primary_phone'))->where_in('_id', $ids);         
            $mresult = $mdb->get('cases');
            
            $cases = array();
            foreach($mresult as $row){
                $cases[$row['_id']] = $row;
            }
            
            return $cases;
            
        }
        
        static function findByFields($fields){
            
            if(isset($fields['id'])){
                $fields['_id'] = (int)$fields['id'];
                unset($fields['id']);
            }
            
            $mdb = Mongo_Db::instance();
            
            foreach($fields as $k => $v){
                $mdb->where(array($k => $v));
            }
            
            $mresult = $mdb->get('cases');
            
            return $mresult;
            
        }
        
        static function buildResult($db_result){
            
            $ids = array();
            foreach($db_result->as_array() as $row){
                $items[$row['id']] = $row;
                $ids[] = (int)$row['id'];
            }
            
            if(empty($ids)){
                return array();
            }

            $mdb = Mongo_Db::instance();
            $mdb->where_in('_id', $ids);         
            $mresult = $mdb->get('cases');
            
            $fields = Model_System_ObjectFields::findAll(1);
            
            $results = array();
            foreach($mresult as $row){
                foreach($fields as $field){
                    $clean_name = $field['clean_name'];
                    $items[$row['_id']][$clean_name] = '';
                    if(isset($row[$clean_name])){
                        $items[$row['_id']][$clean_name] = $row[$clean_name];
                    }
                }
            }

            return $items;
            
        }
        
        static function buildResultFromMongo($mresult){
            $ids = array();
            foreach($mresult as $row){
                $holding[$row['_id']] = $row;
                $ids[] = $row['_id'];
            }
            
            if(empty($ids)){
                return array();
            }
            
            $result = DB::select('c.*', array(DB::expr('CONCAT(u.first_name, " ", u.last_name)'), 'sales_rep_name'))
                            ->from(array('cases','c'))
                            ->join(array('users','u'), 'LEFT')->on('u.id', '=', 'c.sales_rep_id')
                            ->where('c.id', 'in', $ids);
            
            if(Model_Account::getType() == 'User'){
                $result->where('sales_rep_id', '=', $_SESSION['user']['id']);
            }
            
            $result = self::setCriteria($result);
            $result = $result->execute();
            
            $items = array();
            foreach($result->as_array() as $row){
                $items[$row['id']] = $holding[$row['id']];
                foreach($row as $k => $v){
                    $items[$row['id']][$k] = $v;
                }
            }
            
            unset($holding);
            
            return $items;
        }
        
        static function add($data, $enforce_dup_filter = true){
            
            if(!isset($data['status'])){
                $data['status'] = 'New';
            }
            
            $base = array('created' => date('Y-m-d H:i:s'));
            
            if(isset($data['campaign'])){
                $campaign = Model_System_Campaign::findByName($data['campaign']);
                if(isset($campaign['id'])){
                    $base['campaign_id'] = $campaign['id'];
                }
            }else{
                //TODO don't hardcode ids or data
                $base['campaign_id'] = 19;
                $data['campaign'] = 'NO CAMPAIGN SET';
            }
            
            if(isset($data['status'])){
                $status = Model_System_Status::findByName($data['status']);
                $base['status_id'] = $status['id'];
            }else{
                $data['status'] = '';
            }
            
            if(isset($data['leads360_id'])){
                $base['id'] = $data['leads360_id'];
            }
            
            $result = DB::insert('cases')->set($base)->execute();
            $case_id = current($result);
            
            $data['_id'] = $data['id'] = (int)$case_id;
            
            if(isset($data['first_name']) && isset($data['last_name'])){
                $data['search_first_name'] = strtolower($data['first_name']);
                $data['search_last_name'] = strtolower($data['last_name']);
                $data['search_name'] = $data['search_first_name'] . ' ' . $data['search_last_name'];
            }
                   
            //TODO use dynamic fields
            foreach(array('primary_phone', 'secondary_phone', 'mobile_phone') as $field){
                if(isset($data[$field])){
                    $data[$field] = preg_replace('/[^0-9]/','', $data[$field]);
                }
            }
            
            //TODO use dynamic fields
            if(isset($data['primary_phone'])){
                $area_code = substr(preg_replace('/[^0-9]/','', $data['primary_phone']), 0, 3);
                $data['timezone'] = Model_System_Timezone::findByAreaCode($area_code);
            }
            
            $mdb = Mongo_Db::instance();
            $insert_id = $mdb->insert('cases', $data);
            
            //DB::update('cases')->set(array('meta_id' => $insert_id))->where('id', '=', $case_id)->execute();
            
            $is_duplicate = false;
            if($enforce_dup_filter){
                $is_duplicate = self::duplicateFilter($case_id);
                if($is_duplicate){
                    //TODO don't hardcode ids
                    Model_Action::run($case_id, 69);
                }
            }
            
            if(!$is_duplicate){
                //TODO don't hardcode ids
                Model_Action::run($case_id, 60, '', 0, false);
            }
            
            return $case_id;
            
        }
        
        static function incActionCount($id){
            self::updateBase($id, array('action_count' => DB::expr('action_count + 1'), 'last_action' => date('Y-m-d H:i:s')));
        }
        
        static function update($id, $data){
            
            $base = array();
            if(isset($data['campaign_id'])){
                $base['campaign_id'] = $data['campaign_id'];
                $campaign = Model_System_Campaign::find($data['campaign_id']);
                $data['campaign'] = $campaign['name'];
                unset($data['campaign_id']);
            }
                
            if(isset($data['sales_rep_id'])){
                $base['sales_rep_id'] = $data['sales_rep_id'];
                unset($data['sales_rep_id']);
            }
            
            if(isset($data['status_id'])){
                $base['status_id'] = $data['status_id'];
                $status = Model_System_Status::find($data['status_id']);
                $data['status'] = $status['name'];
                unset($data['status_id']);
            }
            
            if(!empty($base)){
                self::updateBase($id, $base);
            }
            
            if(isset($data['first_name']) && isset($data['last_name'])){
                $data['search_first_name'] = strtolower($data['first_name']);
                $data['search_last_name'] = strtolower($data['last_name']);
                $data['search_name'] = $data['search_first_name'] . ' ' . $data['search_last_name'];
            }
            
            //TODO use dynamic fields
            foreach(array('primary_phone', 'secondary_phone', 'mobile_phone') as $field){
                if(isset($data[$field])){
                    $data[$field] = preg_replace('/[^0-9]/','', $data[$field]);
                }
            }
            
            $mdb = Mongo_Db::instance();
            $mdb->where(array('_id' => (int)$id))->update('cases', $data);
        }
        
        static function updateBase($id, $data){
            DB::update('cases')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function updateStatus($id, $status_id){

            $status = Model_System_Status::find($status_id);
            
            DB::update('cases')->set(array('status_id' => $status_id, 'last_action' => date('Y-m-d H:i:s')))->where('id', '=', $id)->execute();
            
            $mdb = Mongo_Db::instance();
            $mdb->where(array('_id' => (int)$id))->update('cases', array('status' => $status['name']));
            
            Model_Log::addActivity($id, 'task', 'Status Changed to: '.$status['name']);
        }
        
        static function importUpdate($data, $case_id){
            
            $where = array();
            if(!empty($case_id)){
                $where['_id'] = (int)$case_id;
            }
            
            $mdb = Mongo_Db::instance();
            $mdb->where($where)->update('cases', $data);
            
            //TODO do this better
/*          This is fired by an action  
            if(isset($data['status'])){
                $status = Model_System_Status::findByName($data['status']);
                self::updateStatus($case_id, $status['id']);
            }
*/            
            if(isset($data['campaign'])){
                $campaign = Model_System_Campaign::findByName($data['campaign']);
                self::updateBase($case_id, array('campaign_id' => $campaign['id']));
            }
            
            return $case_id;
            
        }
        
        static function import($data, $case_id){              
            if(empty($case_id)){
                return self::add($data);
            }else{
                return self::importUpdate($data, $case_id);
            }
        }
        
        static function getDBFields(){
            return array('status_id','campaign_id','sales_rep_id','closer_id');
        }
        
        static function assignToRep($case_ids, $rep_user_id){
            
            if(empty($case_ids)){
                return;
            }
            
            if(!is_array($case_ids)){
                $case_ids = array($case_ids);
            }
            
            $user = Model_System_User::find($rep_user_id);
            
            if(empty($user)){
                throw new Exception("Can't find user ID ".$rep_user_id);
            }
            
            self::batchUpdate($case_ids, array('sales_rep_id' => $rep_user_id));
 
            return count($case_ids). ' case'.(count($case_ids)==1?' was':'s were').' reassigned to user: '.$user['first_name'].' '.$user['last_name'];
            
        }
        
        static function assignToCampaign($case_ids, $campaign_id){
            
            if(empty($case_ids)){
                return;
            }
            
            if(!is_array($case_ids)){
                $case_ids = array($case_ids);
            }
            
            $campaign = Model_System_Campaign::find($campaign_id);
            
            if(empty($campaign)){
                throw new Exception("Can't find Campaign ID ".$campaign_id);
            }
            
            self::batchUpdate($case_ids, array('campaign_id' => $campaign_id, 'campaign' => $campaign['name']));
 
            return count($case_ids). ' case'.(count($case_ids)==1?' was':'s were').' reassigned to campaign: '.$campaign['name'];
            
        }
        
        static function batchUpdate($case_ids, $data){
            
            if(empty($case_ids)){
                return;
            }
            
            if(!is_array($case_ids)){
                $case_ids = array($case_ids);
            }
            
            //TODO use dynamic fields
            $db_fields = self::getDBFields();
            
            $db_update = array();
            foreach($db_fields as $field){
                if(isset($data[$field])){
                    $db_update[$field] = $data[$field];
                    unset($data[$field]);
                }
            }
            
            if(!empty($db_update)){
                DB::update('cases')->set($db_update)->where('id', 'in', $case_ids)->execute();
            }

            if(!empty($data)){

                foreach($case_ids as $k => $id){
                    $case_ids[$k] = (int)$id;
                }
                
                $mdb = Mongo_Db::instance();
                $mdb->where_in('_id', $case_ids)->update_all('cases', $data);
            }
            
        }
        
        static function duplicateFilter($id){
            
            $new = self::find($id);
            
            //find phone fields
            $fields = Model_System_ObjectFields::findByType(1, 10);
            
            $mdb = Mongo_Db::instance();
            $mdb->count('cases');
            
            $select_fields = array();
            foreach($fields as $f){
                $select_fields[] = $f['clean_name'];
            }

            foreach($fields as $f){
                foreach($select_fields as $sfv){
                    if(!empty($new[$sfv])){
                        $cond = array($f['clean_name'] => (string)$new[$sfv]);
                        $mdb->or_where($cond);
                    }
                }
            }
            
            $select_fields[] = '_id';
            $mdb->select($select_fields);
            
            $matches = $mdb->get('cases');
            
            $matched_ids = array();
            foreach($matches as $m){
                if($m['_id'] != $id){
                    $matched_ids[] = $m['_id'];
                }
            }
            
            if(!empty($matched_ids)){
                self::update($id, array('duplicates' => $matched_ids, 'status' => 'Duplicate'));
                self::updateBase($id, array('is_duplicate' => 1));
                return true;
            }
            
            return false;

        }
        
        static function findDuplicates(){
            
            $result = DB::select()->from('cases')->where('is_duplicate', '=', 1)->execute();
            return self::buildResult($result);
            
        }
        
        static function findExpired($rules){
            
            $query = DB::select('id', 'status_id')->from('cases');
            
            foreach($rules as $r){
                $expired_date = date('Y-m-d', strtotime('-'.$r['expiry_days'].' days'));
                $query->or_where_open()->where('status_id','=',$r['id'])->where('last_action', '<', $expired_date)->or_where_close();
            }
            
            $result = $query->execute();
            
            return $result->as_array();
            
        }
        
        static function getActionHeader($case){
            $data['case'] = $case;
            $data['activity'] = Model_Log::findActivity($case['id'], 'action');
            $data['actions'] = Model_System_Action::findByStatus($data['case']['status_id']);
            $data['campaigns'] = Model_System_Campaign::findAll();
            $data['users'] = Model_System_User::findByDepartment(array('sales', 'agent'));
            return View::factory('case/header', $data)->render();
        }
        
        static function getTotalFees($case_id){
            
            $case = self::find($case_id);
            $fee_fields = Model_System_ObjectFields::findFeeFields(1);
            
            $fees = array();
            foreach($fee_fields as $f){
                if(isset($case[$f['clean_name']]) && is_numeric($case[$f['clean_name']])){
                    $fees[] = $case[$f['clean_name']];
                }
            }
            
            return array_sum($fees);
            
        }
        
        static function export($data){
                        
            if(!isset($data['status_ids']) && !isset($data['campaign_ids'])){
                throw new Exception('You must select at least one campaign or one status to export from');
            }
            
            if(!isset($data['db']) || !in_array('id', $data['db'])){
                $data['db'][] = 'id';
            }
            
            $query = DB::select_array($data['db'])
                    ->from('cases')
                    ->where('is_duplicate', '=', $data['is_duplicate']);
                    
            if(isset($data['status_ids'])){
                $query->where('status_id', 'in', $data['status_ids']);
            }   
            
            if(isset($data['campaign_ids'])){
                $query->where('campaign_id', 'in', $data['campaign_ids']);
            }             
            
            $result = $query->execute();
            
            $cases = array();
            foreach($result->as_array() as $row){
                $cases[$row['id']] = $row;
            }
            
            if(empty($cases)){
                throw new Exception('No Cases Found');
            }
            
            unset($result);
            
            if(!isset($data['ds']) || !in_array('_id', $data['ds'])){
                $data['ds'][] = '_id';
            }
            $mdb = Mongo_Db::instance();
            $mdb->where_in('_id', array_keys($cases));  
            $mdb->select($data['ds']);
            $mresult = $mdb->get('cases');

            header("Content-type: text/csv");  
            header("Cache-Control: no-store, no-cache");  
            header('Content-Disposition: attachment; filename="case export '.date('Ymd Hi').'.csv"');  
            
            $outstream = fopen("php://output",'w');
            
            unset($data['ds'][array_search('_id', $data['ds'])]);
            $headers = array_merge($data['db'], $data['ds']);
            
            fputcsv($outstream, $headers, ',', '"'); 
            
            foreach($mresult as $mrow){
                $id = $mrow['_id'];
                unset($mrow['_id']);
                
                $mrecord = array();
                foreach($data['ds'] as $k => $v){
                    if(isset($mrow[$v])){
                        $mrecord[$v] = $mrow[$v];
                    }else{
                        $mrecord[$v] = '';
                    }
                }
                
                $row = array_merge($cases[$id], $mrecord);
                fputcsv($outstream, $row, ',', '"');  
            }
            
            fclose($outstream);
            exit;
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            return $val;
        }
        
    }