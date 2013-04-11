<?php

    class Controller_Case extends Controller_Base{
        
        function action_listing(){

            $data['statuses'] = Model_System_Status::findAll(1);
            $data['campaigns'] = Model_System_Campaign::findAll();
            $data['users'] = Model_System_User::findByType('User');
            
            if(isset($_POST['filter'])){
                $_SESSION['filter'] = $_POST['filter'];
            }
            
            $sort_field = 'created';
            $order = 'desc';
            
            if(isset($_GET['sort'])){
                $sort_field = $_GET['sort'];
            }
            
            if(isset($_GET['order'])){
                $order = $_GET['order'];
            }
            
            if(isset($_SESSION['filter'])){
                $data['cases'] = Model_Case::findByFilter($_SESSION['filter'], $this->offset, $this->limit, $sort_field, $order);
                $data['pagination'] = array('limit' => $this->limit, 'total_items' => Model_Case::findByFilter($_SESSION['filter'], null, null, null, null, true));
            }else{
                $data['cases'] = Model_Case::findAll($this->offset, $this->limit, $sort_field, $order);
                $data['pagination'] = array('limit' => $this->limit, 'total_items' => Model_Case::countItems());
            }
            
            $this->response->body = View::factory('layout', array('l' => 'case/listing', 'c' => $data));
            
        }
        
        function action_search(){
            
            if(!isset($_POST['query'])){
                response::redirect('/case/listing');
            }
            
            $data['cases'] = Model_Case::search($_POST['query']);
            $data['pagination'] = array('limit' => 0, 'total_items' => 0);
            $this->response->body = View::factory('layout', array('l' => 'case/listing', 'c' => $data));
            
        }
        
        function action_add($data){
            $id = Model_Case::insert($data);
            return $id;
        }
        
        function action_update($id){
            
            if(!empty($_POST)){
            
                try{
                    Model_Case::update($id, $_POST);
                    Notify::success('Case Updated');
                    Response::redirect('/case/view/'.$id.'/#profile');
                }catch(Exception $e){
                    Notify::error($e);
                }
            
            }
            
            $data['case'] = Model_Case::find($id);
            $data['fgroups'] = Model_System_ObjectFields::findAllGroups();
            $data['fields'] = Model_System_ObjectFields::findAllGrouped(1);
            $data['options'] = Model_System_ObjectFields::findAllOptions(1);
            
            $this->response->body = View::factory('layout', array('l' => 'case/form', 'c' => $data));
            
        }
        
        function action_view($id){
            
            $data['case'] = Model_Case::find($id);
            $data['activity'] = Model_Log::findActivity($id, 'action');
            $data['actions'] = Model_System_Action::findByStatus($data['case']['status_id']);
            $data['fgroups'] = Model_System_ObjectFields::findAllGroups();
            $data['fields'] = Model_System_ObjectFields::findAllGrouped(1);
            $data['documents'] = Model_Document::findByCaseID($id);
            $data['forms'] = Model_System_Form::findAll();
            $data['campaigns'] = Model_System_Campaign::findAll();
            $data['users'] = Model_System_User::findByDepartment('sales');
            
            $this->response->body = View::factory('layout', array('l' => 'case/view', 'c' => $data));
            
        }
        
        function action_upload_document($case_id){
  
            $result = Model_Document::add($case_id, $_FILES['files']);
            print json_encode(array($result));
            
        }
        
        function action_run_action($id){
            
            try{
                Model_Action::run($id, $_POST['action_id'], $_POST['note']);
                notify::success('Case Updated');
            }catch(Exception $e){
                notify::error($e);
            }
            
            Response::redirect('case/view/'.$id);
        }
        
        function action_change_status($case_id){
            Model_Action::changeStatus($case_id, $_POST['status_id']);
            response::redirect('/case/view/'.$case_id);
        }
        
        function action_quick_update($id = null){
            
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }
            
            $val = Model_Case::validate('quick_update');
            
            if($val->run()){
                Model_Case::updateBase($id, array('sales_rep_id' => $_POST['sales_rep_id']));
                unset($_POST['sales_rep_id']);
                Model_Case::update($id, $_POST);
                notify::success('Case Updated');
            }
            
            $data['id'] = $id;
            $data['case'] = Model_Case::find($id);
            $data['statuses'] = Model_System_Status::findAll(1);
            $data['actions'] = Model_System_Action::findByStatus($data['case']['status_id']);
            $data['activity'] = Model_Log::findActivity($id, 'action');
            $data['campaigns'] = Model_System_Campaign::findAll();
            $data['users'] = Model_System_User::findByDepartment('sales');
            $this->response->body = View::factory('case/screenpop', $data);
        }
        
        function action_save_quick_update($id){
            if(!empty($_POST)){
                
                $run_action = (isset($_POST['run_action'])?true:false);
                $action_id = $_POST['action_id'];
                $action_note = $_POST['note'];
                
                unset($_POST['run_action'], $_POST['action_id'], $_POST['note']);
                
                Model_Case::update($id, $_POST);
                
                if($run_action){
                    Model_Action::run($id, $action_id, $action_note);
                }
            }
            
            Response::redirect('/case/quick_update/?id='.$id);
            
        }
        
        function action_quick_search(){
            
            try{
                $id = Model_Case::quickSearch($_POST['query']);
            }catch(Exception $e){
                notify::error($e);
                header('location: '.$_SERVER['HTTP_REFERER']);
                exit;
            }

            Response::redirect('/case/quick_update/?id='.$id);
            
        }
        
        function action_get_recent_activity($id, $limit = 5){
            $actions = Model_Log::findActivity($id, 'action', $limit);
            
            $activity = array();
            foreach($actions as $a){
                $activity[] = array(
                                    'name' => (empty($a['name'])?'System Action':$a['name']),
                                    'message' => $a['message'],
                                    'note' => $a['note'],
                                    'ts' => format::relative_date($a['ts'])
                                    );
            }
            
            print json_encode($activity);
        }
        
        function action_clear_filter(){
            if(isset($_SESSION['filter'])){
                unset($_SESSION['filter']);
            }
            header('location: '.$_SERVER['HTTP_REFERER']);
            exit;
        }
        
        function action_replay_import($start_id, $end_id){
            
            set_time_limit(600);
            
            $result = DB::select()->from('log_imports')->where('id', 'between', array($start_id, $end_id))->where('uri','like','/api/import/3%')->execute();

            foreach($result->as_array() as $row){
                $data = unserialize($row['content']);
                Model_Action::httpRequest('http://dev.crm.pinnacletaxadvisors.com/api/import/3/35b4831f1e0e61f429d7dfd137a5c797f39505b4', 'post', $data);
            }
        }
        
        function action_manage_expired(){
            
            $rules = Model_System_Status::findExpiryRules();
            $expired = Model_Case::findExpired($rules);

            foreach($expired as $e){
                print '<p>Running Action ID: '.$rules[$e['status_id']]['expiry_action_id'].' on Case ID: '.$e['id'].'</p>';
                Model_Action::run($e['id'], $rules[$e['status_id']]['expiry_action_id'], 'Case expired status of '.$rules[$e['status_id']]['name'].' after '.$rules[$e['status_id']]['expiry_days'].' days');
            }
            
        }
   /*     
        function action_set_ids(){
            
            set_time_limit(600);
            
            $result = Model_Case::findAll(0,10000);
            
            foreach($result as $row){
                if(!empty($row['leads360_id'])){
                    try{
                    Model_Case::updateBase($row['id'], array('id' => $row['leads360_id']));
                    Model_Case::update($row['id'], array('id' => $row['leads360_id'], '_id' => (int)$row['leads360_id']));
                    }catch(Exception $e){
                        print '<p>'.$e->getMessage().'</p>';
                    }
                }
            }
        }
    */
  /*      
        function action_update_search(){
            set_time_limit(600);
            
            $mdb = Mongo_Db::instance();
            $result = $mdb->get('cases');
            
            foreach($result as $row){
                Model_Case::update($row['id'], array('first_name' => $row['first_name'], 'last_name' => $row['last_name']));
            }
        }
    */    
      /*  
        function action_update_all(){
            
            set_time_limit(600);
            
            $mdb = Mongo_Db::instance();
            $result = $mdb->get('cases');
            
            foreach($result as $row){
                $campaign = Model_System_Campaign::findByName($row['campaign']);
                Model_Case::updateBase($row['id'], array('campaign_id' => $campaign['id']));
            }
            
            $result = DB::select('case_id', DB::expr('count(id) as actions'))->from('log_activity')->group_by('case_id')->execute();
            
            foreach($result->as_array() as $row){
                Model_Case::updateBase($row['case_id'], array('action_count' => $row['actions']));
            }
            
        }
     */
        
    }
