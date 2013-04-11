<?php

    class Controller_Application extends Controller_Base {

        protected $application;

        function before(){
            parent::before();
            if (Uri::segment(2)) {
                $non_apps = array('index', 'listing', 'notes', 'add_note', 'open_files','run_action','quick_update','by_filter');
                if (!in_array(Uri::segment(2), $non_apps)) {
                    try {
                        $this->application = Model_Application::findApplication(Uri::segment(3));
                    } catch(\Exception $e) {
                        \Notify::error($e);
                        header('Location:/application/listing');
                        exit;
                    }
                    if (isset($_SESSION['active_punch'])) {
                        if ($_SESSION['active_punch']['application_id'] != Uri::segment(3)) {
                            Model_Punchclock::punchOut($_SESSION['active_punch']['id']);
                            unset($_SESSION['active_punch']);
                        }
                    }
                    if (!isset($_SESSION['active_punch'])) {
                        $last_punch = Model_Punchclock::findLastOpenPunch($_SESSION['user']['id']);
                        if (!empty($last_punch)) {
                            Model_Punchclock::punchOut($last_punch['id']);
                        }
                        $insert_id = Model_Punchclock::punchIn(Uri::segment(3), $_SESSION['user']['id']);
                        $_SESSION['active_punch']['id'] = $insert_id;
                        $_SESSION['active_punch']['application_id'] = Uri::segment(3);
                        \Notify::success('You\'ve been clocked into this file.');
                    }
                }
            } else {
                header('Location:/application/listing');
                exit;
            }
        }

        function action_index(){
            if (Uri::segment(3)) {
                header('Location:/application/view/'.Uri::segment(3));
                exit;
            } else {
                header('Location:/application/listing');
                exit;
            }
        }

        function action_listing() {
            
            if(isset($_GET['q'])){
                $data['applications'] = Model_Application::search($_GET['q'], $this->offset, $this->limit);
            }else{
                $data['applications'] = Model_Application::findApplications($this->offset, $this->limit);
            }
            
            
            $app_ids = array();
            foreach($data['applications'] as $v) {
                $app_ids[] = $v['id'];
            }
            $data['time_spent'] = Model_Punchclock::findTimeOnApplications($app_ids);
            $data['pagination'] = array('limit' => $this->limit, 'total_items' => Model_Application::countAll());
            $this->response->body = View::factory('layout', array('l' => 'application/listing', 'c' => $data));
        }
        
        function action_by_filter(){

            $priority = null;
            $status = null;
            $payment = null;
            
            if(isset($_GET['priority'])){ $priority = $_GET['priority']; }
            if(isset($_GET['status'])){ $status = $_GET['status']; }
            if(isset($_GET['payment'])){ $payment = $_GET['payment']; }
            
            $data['applications'] = Model_Application::findByFilter($status, $payment, $priority, $this->offset, $this->limit);
            $app_ids = array();
            foreach($data['applications'] as $v) {
                $app_ids[] = $v['id'];
            }
            $data['time_spent'] = Model_Punchclock::findTimeOnApplications($app_ids);
            $data['pagination'] = array('limit' => $this->limit, 'total_items' => count(Model_Application::findByFilter($status, $payment, $priority, 0, 1000)));
            $this->response->body = View::factory('layout', array('l' => 'application/listing', 'c' => $data));
            
        }
        
        function action_quick_update($app_id){      
            Model_Application::update($app_id, $_POST);
        }
        
        function action_run_action(){
            
            try{
                Model_Action::run($_POST['app_id'], $_POST['action_id']);
                notify::success('Application Updated');
            }catch(Exception $e){
                notify::error($e);
            }
            
            Response::redirect('application/view/'.$_POST['app_id']);

        }
        
        function action_activity($app_id){
            
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['activities'] = Model_Log::findActivity($app_id);
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/activity', 'c' => $data));
            
        }
        
        function action_documents($app_id){
            $data['documents'] = Model_Document::findByAppID($app_id);
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/documents', 'c' => $data));
        }
        
        function action_forms($app_id){
            $data['forms'] = Model_System_Form::findAll();
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/forms', 'c' => $data));
        }
        
        function action_upload_document($app_id){
  
            $result = Model_Document::add($app_id, $_FILES['files']);
            print json_encode(array($result));
            
        }
/*        
        function action_test($app_id){
            //Model_Action::SendEmail($app_id, 1);
            Model_Action::makeCall($app_id, 1);
            //$fields = Model_System_TemplateFields::load($app_id);
        }
  */      
//        function action_open_files() {
//            if (count($_SESSION['punches'])) {
//                $ids = array();
//                foreach($_SESSION['punches'] as $k => $v) {
//                    $ids[] = $k;
//                }
//                $applications = Model_Application::findByIDs($ids);
//                $data['punches'] = Model_Punchclock::findOpenUserPunches($_SESSION['user']['id']);
//                $data['applications'] = array();
//
//                foreach($applications as $a) {
//                    $data['applications'][$a['id']] = $a;
//                }
//            } else {
//                $data['punches'] = array();
//            }
//            $this->response->body = View::factory('layout', array('l' => 'application/open', 'c' => $data));
//        }

        function action_add() {
            $data = array();
            $this->response->body = View::factory('layout', array('l' => 'application/add', 'c' => $data));
        }

        function action_view() {
            $data['application'] = $this->application;
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $app_ids = array($this->application['application']['id']);
            $data['time_spent'] = Model_Punchclock::findTimeOnApplications($app_ids);
            $data['actions'] = Model_System_Action::findByStatus($this->application['application']['status_id']);
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/view', 'c' => $data));
        }

        function action_clockout() {
            try {
                $punch_out = Model_Punchclock::punchOut($_SESSION['active_punch']['id']);
                if ($punch_out) {
                    unset($_SESSION['active_punch']);
                    \Notify::success('You\'ve been clocked out.');
                } else {
                    \Notify::error('You were not clocked out. Please contact an administrator.');
                }
            } catch(\Exception $e) {
                \Notify::error('You were not clocked out. Please contact an administrator.');
            }
            header('Location: /application/listing');
            exit;
        }

        function action_profile() {
            if (!empty($_POST)) {
                try {
                    $_POST['phone_home'] = \format::number_string($_POST['phone_home']);
                    $_POST['phone_work'] = \format::number_string($_POST['phone_work']);
                    $_POST['phone_mobile'] = \format::number_string($_POST['phone_mobile']);
                    $_POST['phone_fax'] = \format::number_string($_POST['phone_fax']);
                    $_POST['ssn'] = \format::number_string($_POST['ssn']);
                    $_POST['dob'] = date('Y-m-d H:i:s', strtotime($_POST['dob']));
                    $_POST['co_phone_home'] = \format::number_string($_POST['co_phone_home']);
                    $_POST['co_phone_work'] = \format::number_string($_POST['co_phone_work']);
                    $_POST['co_phone_mobile'] = \format::number_string($_POST['co_phone_mobile']);
                    $_POST['co_ssn'] = \format::number_string($_POST['co_ssn']);
                    $_POST['co_dob'] = date('Y-m-d H:i:s', strtotime($_POST['co_dob']));

                    Model_Application::updateProfile($_POST);
                    \Notify::success('Profile updated successfully.');
                    header('Location:/application/profile/'.Uri::segment(3));
                    exit;
                } catch (\Exception $e) {
                    \Notify::error($e);
                }
            }
            $data['profile'] = $this->application['profile'];
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/profile', 'c' => $data));
        }

        function action_employment() {
            if (!empty($_POST)) {
                try {
                    if (strlen($_POST['employment_id'])) {
                        Model_Application::updateEmployment($_POST);
                    } else {
                        unset($_POST['employment_id']);
                        $_POST['user_id'] = $this->application['application']['user_id'];
                        Model_Application::insertEmployment($_POST);
                    }
                    
                    \Notify::success('Employment information updated successfully.');
                    header('Location:/application/employment/'.Uri::segment(3));
                    exit;
                } catch (\Exception $e) {
                    \Notify::error($e);
                }
            }
            $employment = $this->application['employment'];
            if (!empty($employment)) {
                $keys = array_keys($employment);
                $data['employment'] = $employment[$keys[0]];
            } else {
                $data['employment'] = array(
                    'id' => null,
                    'user_id' => null,
                    'status' => null,
                    'company_name' => null,
                    'title' => null,
                    'job_description' => null,
                    'business_type' => null,
                    'employer_id' => null,
                    'business_taxes' => null
                );
            }
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/employment', 'c' => $data));
        }

        function action_tax() {
            if (!empty($_POST)) {
                $tax_activity = $_POST['tax_activity'];
                unset($_POST['tax_activity']);
                try {
                    if (strlen($_POST['tax_liability'])) {
                        $_POST['tax_liability'] = number_format($_POST['tax_liability'], 2, '.', '');
                    }
                    if (strlen($_POST['fed_monthly_payment'])) {
                        $_POST['fed_monthly_payment'] = number_format($_POST['fed_monthly_payment'], 2, '.', '');
                    }
                    if (strlen($_POST['state_monthly_payment'])) {
                        $_POST['state_monthly_payment'] = number_format($_POST['state_monthly_payment'], 2, '.', '');
                    }
                    if (strlen($_POST['fed_date_plan_started'])) {
                        $_POST['fed_date_plan_started'] = date('Y-m-d H:i:s', strtotime($_POST['fed_date_plan_started']));
                    } else {
                        unset($_POST['fed_date_plan_started']);
                    }
                    if (strlen($_POST['state_date_plan_started'])) {
                        $_POST['state_date_plan_started'] = date('Y-m-d H:i:s', strtotime($_POST['state_date_plan_started']));
                    } else {
                        unset($_POST['state_date_plan_started']);
                    }
                    if (strlen($_POST['bankruptcy_discharge_date'])) {
                        $_POST['bankruptcy_discharge_date'] = date('Y-m-d H:i:s', strtotime($_POST['bankruptcy_discharge_date']));
                    } else {
                        unset($_POST['bankruptcy_discharge_date']);
                    }
                    if (strlen($_POST['last_status_irslogics'])) {
                        $_POST['last_status_irslogics'] = date('Y-m-d H:i:s', strtotime($_POST['last_status_irslogics']));
                    } else {
                        unset($_POST['last_status_irslogics']);
                    }
                    if (strlen($_POST['compliance_closed_date'])) {
                        $_POST['compliance_closed_date'] = date('Y-m-d H:i:s', strtotime($_POST['compliance_closed_date']));
                    } else {
                        unset($_POST['compliance_closed_date']);
                    }

                    if (strlen($_POST['tax_problem_id'])) {
                        Model_Application::updateTaxProblem($_POST);
                    } else {
                        unset($_POST['tax_problem_id']);
                        $_POST['user_id'] = $this->application['application']['user_id'];
                        Model_Application::insertTaxProblem($_POST);
                    }

                    foreach ($tax_activity as $k => $v) {
                        foreach ($v as $a => $b) {
                            if (isset($this->application['tax_activity'][$k][$a])) {
                                $update = $this->application['tax_activity'][$k][$a];
                                $update['owed'] = $b['owed'];
                                $update['not_filed'] = $b['not_filed'];
                                Model_Application::updateTaxActivity($update);
                            } else {
                                $insert = array(
                                    'user_id' => $this->application['application']['user_id'],
                                    'branch' => ucwords($k),
                                    'year' => $a,
                                    'owed' => $b['owed'],
                                    'not_filed' => $b['not_filed']
                                );
                                Model_Application::insertTaxActivity($insert);
                            }
                        }
                    }

                    \Notify::success('Tax information updated successfully.');
                    header('Location:/application/tax/'.Uri::segment(3));
                    exit;
                } catch (\Exception $e) {
                    \Notify::error($e);
                }
            }
            $data['tax_problem'] = $this->application['tax_problem'];
            $data['tax_activity'] = $this->application['tax_activity'];
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/tax', 'c' => $data));
        }

        function action_personal() {
            if (!empty($_POST)) {
                try {
                    foreach($_POST as $k => $v) {
                        if ($k != 'persons_under_65' && $k != 'persons_over_65' && $k != 'personal_id') {
                            if (strlen($_POST[$k]) && $_POST[$k] != '0.00') {
                                $_POST[$k] = number_format($_POST[$k], 2, '.', '');
                            } else {
                                $_POST[$k] = 0;
                            }
                        }
                    }

                    if (strlen($_POST['personal_id'])) {
                        Model_Application::updatePersonal($_POST);
                    } else {
                        unset($_POST['personal_id']);
                        $_POST['user_id'] = $this->application['application']['user_id'];
                        Model_Application::insertPersonal($_POST);
                    }

                    \Notify::success('Personal finances updated successfully.');
                    header('Location:/application/personal/'.Uri::segment(3));
                    exit;
                } catch (\Exception $e) {
                    \Notify::error($e);
                }
            }
            $data['personal'] = $this->application['finances']['personal'];
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/personal', 'c' => $data));
        }

        function action_business() {
            if (!empty($_POST)) {
                try {
                    foreach($_POST as $k => $v) {
                        if ($k != 'business_id') {
                            if (strlen($_POST[$k]) && $_POST[$k] != '0.00') {
                                $_POST[$k] = number_format($_POST[$k], 2, '.', '');
                            } else {
                                $_POST[$k] = 0;
                            }
                        }
                    }
                    if (strlen($_POST['business_id'])) {
                        Model_Application::updateBusiness($_POST);
                    } else {
                        unset($_POST['business_id']);
                        $_POST['user_id'] = $this->application['application']['user_id'];
                        Model_Application::insertBusiness($_POST);
                    }
                    \Notify::success('Business finances updated successfully.');
                    header('Location:/application/business/'.Uri::segment(3));
                    exit;
                } catch (\Exception $e) {
                    \Notify::error($e);
                }
            }
            $data['business'] = $this->application['finances']['business'];
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/business', 'c' => $data));
        }

        function action_billing() {
            if (!empty($_POST)) {
                try {
                    $_POST['bank_routing_number'] = \format::number_string($_POST['bank_routing_number']);
                    $_POST['bank_account_number'] = \format::number_string($_POST['bank_account_number']);
                    $_POST['cc_number'] = \format::number_string($_POST['cc_number']);
                    $_POST['cc_exp_date'] = \format::number_string($_POST['cc_exp_date']);
                    $_POST['cc_cvv'] = \format::number_string($_POST['cc_cvv']);
                    if (!isset($_POST['cc_same_as_mailing'])) {
                        $_POST['cc_same_as_mailing'] = 0;
                    }

                    Model_Application::updateProfile($_POST);
                    \Notify::success('Billing Account information updated successfully.');
                    header('Location:/application/billing/'.Uri::segment(3));
                    exit;
                } catch (\Exception $e) {
                    \Notify::error($e);
                }
            }
            $data['billing'] = $this->application['profile']['billing'];
            $data['billing']['user_id'] = $this->application['application']['user_id'];
            $data['billing']['profile_address'] = $this->application['profile']['address'];
            $data['billing']['profile_city'] = $this->application['profile']['city'];
            $data['billing']['profile_state'] = $this->application['profile']['state'];
            $data['billing']['profile_zip'] = $this->application['profile']['zip'];
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/billing', 'c' => $data));
        }

        function action_fees() {
            if (!empty($_POST)) {
                try {
                    $fees = array();
                    $fees['tax_problem_id'] = $_POST['tax_problem_id'];
                    $fees['service_eval_fee'] = $_POST['service_eval_fee'];
                    $fees['service_file_setup_fee'] = $_POST['service_file_setup_fee'];
                    $fees['service_file_service_fee'] = $_POST['service_file_service_fee'];
                    $fees['service_settlement_fee'] = $_POST['service_settlement_fee'];

                    Model_Application::updateTaxProblem($fees);

                    foreach ($_POST['payments'] as $k => $v) {

                        $payment = array(
                            'application_id' => Uri::segment(3),
                            'payment_number' => $k,
                            'amount_due' => $v['amount_due'],
                            'date_due' => date('Y-m-d H:i:s', strtotime($v['date_due']))
                        );
                        if (isset($this->application['payments'][$k])) {
                            $payment['id'] = $this->application['payments'][$k]['id'];
                            Model_Application::updatePayment($payment);
                        } else {
                            if (!strlen($v['amount_due']) || !is_numeric($v['amount_due'])) {
                                continue;
                            }
                            Model_Application::insertPayment($payment);
                        }
                    }

                    \Notify::success('Fees and Payments updated successfully.');
                    header('Location:/application/fees/'.Uri::segment(3));
                    exit;
                } catch (\Exception $e) {
                    \Notify::error($e);
                }
            }
            $data['payments'] = $this->application['payments'];
            $data['fees'] = $this->application['tax_problem']['fees'];
            $data['fees']['tax_problem_id'] = $this->application['tax_problem']['tax_problem_id'];
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/fees', 'c' => $data));
        }

        function action_payments() {
            if (!empty($_POST)) {
                try {
                    foreach ($_POST['payments'] as $k => $v) {
                        if (strlen($v['received_amount']) && strlen($v['received'])) {
                            $payment = array(
                                'id' => $this->application['payments'][$k]['id'],
                                'application_id' => Uri::segment(3),
                                'type' => 'primary',
                                'payment_status' => $v['payment_status'],
                                'payment_number' => $k,
                                'received' => date('Y-m-d H:i:s', strtotime($v['received'])),
                                'received_by' => $_SESSION['user']['id'],
                                'received_amount' => $v['received_amount'],
                                'commission_to' => $v['commission_to'],
                                'commission_percent' => $v['commission_percent'],
                                'commission_amount' => $v['commission_amount'],
                                'commission_paid' => date('Y-m-d H:i:s', strtotime($v['commission_paid'])),
                                'closer_commission_to' => $v['closer_commission_to'],
                                'closer_commission_percent' => $v['closer_commission_percent'],
                                'closer_commission_amount' => $v['closer_commission_amount'],
                                'closer_commission_paid' => date('Y-m-d H:i:s', strtotime($v['closer_commission_paid']))
                            );
                            Model_Application::updatePayment($payment);
                        }
                    }

                    \Notify::success('Payment received. Commissions updated.');
                    header('Location:/application/payments/'.Uri::segment(3));
                    exit;
                } catch (\Exception $e) {
                    \Notify::error($e);
                }
            }
            $data['users'] = Model_User::findAll();
            $data['payments'] = $this->application['payments'];
            $data['fees'] = $this->application['tax_problem']['fees'];
            $data['fees']['tax_problem_id'] = $this->application['tax_problem']['tax_problem_id'];
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/payments', 'c' => $data));
        }

        function action_add_note() {
            $ajax = false;
            if (isset($_POST['json_note'])) {
                $ajax = true;
                $data = json_decode($_POST['json_note']);
                unset($_POST['json_note']);
                $_POST['title'] = (string)$data->title;
                $_POST['note'] = (string)$data->note;
                if (isset($_POST['first_name'])) {
                    unset($_POST['first_name']);
                }
                if (isset($_POST['last_name'])) {
                    unset($_POST['last_name']);
                }
            }
            $_POST['application_id'] = Uri::segment(3);
            $_POST['created'] = date('Y-m-d H:i:s');
            $_POST['created_by'] = $_SESSION['user']['id'];
            
            try {
                Model_Application::add_note($_POST);
                if ($ajax) {
                    print 'true';
                } else {
                    header('Location: /application/view/'.Uri::segment(3));
                    exit;
                }
            } catch(\Exception $e) {
                if ($ajax) {
                    print 'false';
                } else {
                    Notify::error($e);
                    header('Location: /application/view/'.Uri::segment(3));
                    exit;
                }
            }
        }

        function action_notes() {
            try {
                $notes = Model_Application::findNotes(Uri::segment(3));
                if (count($notes)) {
                    foreach ($notes as $k => $v) {
                        $notes[$k]['created'] = date('n/j/Y g:ia', strtotime($notes[$k]['created']));
                    }
                    print json_encode($notes);
                } else {
                    print 'false';
                }
            } catch(\Exception $e) {
                print 'false';
            }
        }

        function action_punches() {
            $data['punches'] = Model_Punchclock::findApplicationPunches(Uri::segment(3));
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/punch_list', 'c' => $data));
        }

        function action_punch_update() {
            if (!empty($_POST)) {
                if (!strlen($_POST['start_date']) || !strlen($_POST['start_time'])) {
                    \Notify::error('You must set a start date and time');
                    header('Location: /application/punch_update/'.Uri::segment(3).'/'.Uri::segment(4));
                    exit;
                }
                $punch_start = strtotime($_POST['start_date'].' '.$_POST['start_time']);
                if ($punch_start === false) {
                    \Notify::error('You must set a valid start date and time');
                    header('Location: /application/punch_update/'.Uri::segment(3).'/'.Uri::segment(4));
                    exit;
                }
                $punch = array(
                    'id' => Uri::segment(4),
                    'in_time' => date('Y-m-d H:i:s', $punch_start)
                );
                if (!strlen($_POST['end_date']) || !strlen($_POST['end_time'])) {
                    $punch['out_time'] = null;
                    $punch['punchtime'] = null;
                } else {
                    $punch_end = strtotime($_POST['end_date'].' '.$_POST['end_time']);
                    if ($punch_end === false) {
                        \Notify::error('You must set a valid end date and time');
                        header('Location: /application/punch_update/'.Uri::segment(3).'/'.Uri::segment(4));
                        exit;
                    }
                    $punch['out_time'] = date('Y-m-d H:i:s', $punch_end);
                    $punch['punchtime'] = $punch_end - $punch_start;
                }
                try {
                    Model_Punchclock::updatePunch($punch);
                    \Notify::success('The punch was updated successfully');
                    header('Location: /application/punches/'.Uri::segment(3));
                    exit;
                } catch (\Exception $e) {
                    \Notify::error($e);
                    header('Location: /application/punch_update/'.Uri::segment(3).'/'.Uri::segment(4));
                    exit;
                }
            }
            $data['punch'] = Model_Punchclock::find(Uri::segment(4));
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/punch_update', 'c' => $data));
        }

        function action_punch_delete() {
            $punch = Model_Punchclock::find(Uri::segment(4));
            if($punch['application_id'] == Uri::segment(3)) {
                try {
                    Model_Punchclock::deletePunch(Uri::segment(4));
                    \Notify::success('The punch was deleted successfully');
                } catch (\Exception $e) {
                    \Notify::error($e);
                }
                header('Location: /application/punches/'.Uri::segment(3));
                exit;
            } else {
                \Notify::error('Could not locate the punch record');
                header('Location: /application/punches/'.Uri::segment(3));
                exit;
            }
        }

        function action_calendar() {
            require_once('/var/www/devcrm/fuel/app/classes/utility/calendar.php');
            if (!isset($_GET['m']) && !isset($_GET['y'])) {
                $data['base_date'] = date("m/d/Y", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
            } else {
                $data['base_date'] = date("m/d/Y", strtotime($_GET['m'].'/01/'.$_GET['y'].' 00:00:00'));
            }

            $data['last_month'] = getDate(strtotime('-1 month', strtotime($data['base_date'])));
            $data['next_month'] = getDate(strtotime('+1 month', strtotime($data['base_date'])));

            $data['calendar'] = new Calendar( );
            $data['calendar']->setCalendarType('month');
            $data['calendar']->setBaseDate($data['base_date']);
            $data['calendar']->enableToday();
            $data['calendar']->setDayBaseUri('/application/calendar_day/'.Uri::segment(3));
            $data['calendar']->setWeekBaseUri('/application/calendar_week/'.Uri::segment(3));

            $tasks = Model_Task::findApplicationTasks(Uri::segment(3));

            foreach ($tasks as $t) {
                if ($t['type'] == 'todo') {
                    if ($t['status'] == 'completed') {
                        $status_date = date('m/d/Y H:i:s', strtotime($t['completed']));
                    } else {
                        $status_date = date('m/d/Y H:i:s', strtotime($t['deadline']));
                    }
                    $type = 'task';
                } else {
                    $status_date = date('m/d/Y H:i:s', strtotime($t['appointment']));
                    $type = 'event';
                }

                $key = strtotime($status_date);
                $date = date('m/d/Y', strtotime($status_date));
                $time = date('H:i:s', strtotime($status_date));

                if (strtotime($status_date) < time() && $t['status'] != 'completed') {
                    if ($t['status'] == 'working') {
                        $status = 'overdue';
                    } else {
                        $status = 'suspended';
                    }
                    $key = time();
                } else {
                    $status = $t['status'];
                }

                $item = array(
                    'key' => $key,
                    'link' => '/application/task_view/'.Uri::segment(3).'/'.$t['id'],
                    'type' => $type,
                    'title' => $t['title'],
                    'description' => $t['description'],
                    'status' => $status,
                    'date' => $date,
                    'time' => $time,
                    'assignee' => $t['assignee_fname'].' '.$t['assignee_lname'],
                    'creator' => $t['created_fname'].' '.$t['created_lname'],
                    'created' => date('m/d/Y H:i:s', strtotime($t['created']))
                );
                $item['classes'] = array($status,$t['access']);
                if (strlen($t['priority_status'])) {
                    $item['classes'][] = $t['priority_status'];
                }
                $data['calendar']->setItem($item);
            }
            
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/calendar', 'c' => $data));
        }

        function action_calendar_week() {
            require_once('/var/www/devcrm/fuel/app/classes/utility/calendar.php');
            if (!isset($_GET['w'])) {
                $parts = getdate();
                if ($parts['wday']) {
                    $data['base_date'] = date("m/d/Y", strtotime('last sunday', time()));
                } else {
                    $data['base_date'] = date("m/d/Y");
                }
            } else {
                $data['base_date'] = date("m/d/Y", $_GET['w']);
            }

            $data['last_week'] = strtotime('-1 week', strtotime($data['base_date']));
            $data['next_week'] = strtotime('+1 week', strtotime($data['base_date']));

            $data['calendar'] = new Calendar( );
            $data['calendar']->setCalendarType('week');
            $data['calendar']->setBaseDate($data['base_date']);
            $data['calendar']->enableToday();
            $data['calendar']->setDayBaseUri('/application/calendar_day/'.Uri::segment(3));
            $data['calendar']->setMonthBaseUri('/application/calendar/'.Uri::segment(3));

            $tasks = Model_Task::findApplicationTasks(Uri::segment(3));

            foreach ($tasks as $t) {
                if ($t['type'] == 'todo') {
                    if ($t['status'] == 'completed') {
                        $status_date = date('m/d/Y H:i:s', strtotime($t['completed']));
                    } else {
                        $status_date = date('m/d/Y H:i:s', strtotime($t['deadline']));
                    }
                    $type = 'task';
                } else {
                    $status_date = date('m/d/Y H:i:s', strtotime($t['appointment']));
                    $type = 'event';
                }

                $key = strtotime($status_date);
                $date = date('m/d/Y', strtotime($status_date));
                $time = date('H:i:s', strtotime($status_date));

                if (strtotime($status_date) < time() && $t['status'] != 'completed') {
                    if ($t['status'] == 'working') {
                        $status = 'overdue';
                    } else {
                        $status = 'suspended';
                    }
                    $key = time();
                } else {
                    $status = $t['status'];
                }

                $item = array(
                    'key' => $key,
                    'link' => '/application/task_view/'.Uri::segment(3).'/'.$t['id'],
                    'type' => $type,
                    'title' => $t['title'],
                    'description' => $t['description'],
                    'status' => $status,
                    'date' => $date,
                    'time' => $time,
                    'assignee' => $t['assignee_fname'].' '.$t['assignee_lname'],
                    'creator' => $t['created_fname'].' '.$t['created_lname'],
                    'created' => date('m/d/Y H:i:s', strtotime($t['created']))
                );
                $item['classes'] = array($status,$t['access']);
                if (strlen($t['priority_status'])) {
                    $item['classes'][] = $t['priority_status'];
                }
                $data['calendar']->setItem($item);
            }

            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/calendar_week', 'c' => $data));
        }

        function action_calendar_day() {
            require_once('/var/www/devcrm/fuel/app/classes/utility/calendar.php');
            if (!isset($_GET['d'])) {
                $data['base_date'] = date("m/d/Y");
            } else {
                $data['base_date'] = date("m/d/Y", $_GET['d']);
            }

            $data['yesterday'] = strtotime('-1 day', strtotime($data['base_date']));
            $data['tomorrow'] = strtotime('+1 day', strtotime($data['base_date']));

            $data['calendar'] = new Calendar( );
            $data['calendar']->setCalendarType('day');
            $data['calendar']->setBaseDate($data['base_date']);
            $data['calendar']->enableToday();
            $data['calendar']->setDayBaseUri('/application/calendar_day/'.Uri::segment(3));
            $data['calendar']->setMonthBaseUri('/application/calendar/'.Uri::segment(3));

            $tasks = Model_Task::findApplicationTasks(Uri::segment(3));

            foreach ($tasks as $t) {
                if ($t['type'] == 'todo') {
                    if ($t['status'] == 'completed') {
                        $status_date = date('m/d/Y H:i:s', strtotime($t['completed']));
                    } else {
                        $status_date = date('m/d/Y H:i:s', strtotime($t['deadline']));
                    }
                    $type = 'task';
                } else {
                    $status_date = date('m/d/Y H:i:s', strtotime($t['appointment']));
                    $type = 'event';
                }

                $key = strtotime($status_date);
                $date = date('m/d/Y', strtotime($status_date));
                $time = date('H:i:s', strtotime($status_date));

                if (strtotime($status_date) < time() && $t['status'] != 'completed') {
                    if ($t['status'] == 'working') {
                        $status = 'overdue';
                    } else {
                        $status = 'suspended';
                    }
                    $key = time();
                } else {
                    $status = $t['status'];
                }

                $item = array(
                    'key' => $key,
                    'link' => '/application/task_view/'.Uri::segment(3).'/'.$t['id'],
                    'type' => $type,
                    'title' => $t['title'],
                    'description' => $t['description'],
                    'status' => $status,
                    'date' => $date,
                    'time' => $time,
                    'duration' => $t['appointment_duration'],
                    'assignee' => $t['assignee_fname'].' '.$t['assignee_lname'],
                    'creator' => $t['created_fname'].' '.$t['created_lname'],
                    'created' => date('m/d/Y H:i:s', strtotime($t['created']))
                );
                $item['classes'] = array($status,$t['access']);
                if (strlen($t['priority_status'])) {
                    $item['classes'][] = $t['priority_status'];
                }
                $data['calendar']->setItem($item);
            }

            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/calendar_day', 'c' => $data));
        }

        function action_task_add() {
            if (!empty($_POST)) {
                if (isset($_POST['user_visibility']) && count($_POST['user_visibility'])) {
                    $user_visibility = $_POST['user_visibility'];
                    unset($_POST['user_visibility']);
                }
                if (isset($_POST['role_visibility']) && count($_POST['role_visibility'])) {
                    $role_visibility = $_POST['role_visibility'];
                    unset($_POST['role_visibility']);
                }
                $date_str = $_POST['due_date'].' '.$_POST['due_time'];
                if ($_POST['type'] == 'todo') {
                    unset($_POST['priority_status']);
                    unset($_POST['appointment_duration']);
                    $_POST['deadline'] = date('Y-m-d H:i:s', strtotime($date_str));
                } else {
                    if (!strlen($_POST['priority_status'])) {
                        unset($_POST['priority_status']);
                    }
                    $_POST['appointment'] = date('Y-m-d H:i:s', strtotime($date_str));
                }

                unset($_POST['due_date']);
                unset($_POST['due_time']);
                $_POST['status'] = 'working';
                $_POST['created'] = date('Y-m-d H:i:s');
                $_POST['creator'] = $_SESSION['user']['id'];
                $_POST['application_id'] = Uri::segment(3);

                $task_id = Model_Task::insertTask($_POST);

                if (isset($user_visibility) && count($user_visibility)) {
                    foreach ($user_visibility as $u) {
                        $values = array(
                            'task_id' => $task_id,
                            'role_id' => 0,
                            'user_id' => $u
                        );
                        Model_Task::insertTaskVisibility($values);
                    }
                }

                if (isset($role_visibility) && count($role_visibility)) {
                    foreach ($role_visibility as $r) {
                        $values = array(
                            'task_id' => $task_id,
                            'role_id' => $r,
                            'user_id' => 0
                        );
                        Model_Task::insertTaskVisibility($values);
                    }
                }

                \Notify::success('The task was added.');
                header('Location: /application/task_view/'.Uri::segment(3).'/'.$task_id);
                exit;
            }
            $access = Model_Access::access($_SESSION['user']['role_id']);
            $data['roles'] = Model_Role::accessRoles($access);
            $data['users'] = Model_User::findAll();
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/task_add', 'c' => $data));
        }

        function action_task_update() {
            if (!empty($_POST)) {
                Model_Task::deleteTaskVisibility(Uri::segment(4));
                if (isset($_POST['user_visibility']) && count($_POST['user_visibility'])) {
                    $user_visibility = $_POST['user_visibility'];
                    unset($_POST['user_visibility']);
                }
                if (isset($_POST['role_visibility']) && count($_POST['role_visibility'])) {
                    $role_visibility = $_POST['role_visibility'];
                    unset($_POST['role_visibility']);
                }
                $date_str = $_POST['due_date'].' '.$_POST['due_time'];
                if ($_POST['type'] == 'todo') {
                    unset($_POST['priority_status']);
                    unset($_POST['appointment_duration']);
                    $_POST['deadline'] = date('Y-m-d H:i:s', strtotime($date_str));
                } else {
                    if (!strlen($_POST['priority_status'])) {
                        unset($_POST['priority_status']);
                    }
                    $_POST['appointment'] = date('Y-m-d H:i:s', strtotime($date_str));
                }

                unset($_POST['due_date']);
                unset($_POST['due_time']);
                $_POST['updated'] = date('Y-m-d H:i:s');
                $_POST['updater'] = $_SESSION['user']['id'];
                $_POST['application_id'] = Uri::segment(3);
                $_POST['id'] = Uri::segment(4);
                if ($_POST['status'] == 'completed') {
                    $_POST['completed'] = date('Y-m-d H:i:s');
                    $_POST['completer'] = $_SESSION['user']['id'];
                }

                Model_Task::updateTask($_POST);

                if (isset($user_visibility) && count($user_visibility)) {
                    foreach ($user_visibility as $u) {
                        $values = array(
                            'task_id' => Uri::segment(4),
                            'role_id' => 0,
                            'user_id' => $u
                        );
                        Model_Task::insertTaskVisibility($values);
                    }
                }

                if (isset($role_visibility) && count($role_visibility)) {
                    foreach ($role_visibility as $r) {
                        $values = array(
                            'task_id' => Uri::segment(4),
                            'role_id' => $r,
                            'user_id' => 0
                        );
                        Model_Task::insertTaskVisibility($values);
                    }
                }

                \Notify::success('The task was updated.');
                header('Location: /application/task_view/'.Uri::segment(3).'/'.Uri::segment(4));
                exit;
            }
            $data['task'] = Model_Task::findTask(Uri::segment(4));
            if ($data['task']['status'] == 'completed') {
                header('Location: /application/task_view/'.Uri::segment(3).'/'.Uri::segment(4));
                exit;
            }
            $access = Model_Access::access($_SESSION['user']['role_id']);
            $data['roles'] = Model_Role::accessRoles($access);
            $data['users'] = Model_User::findAll();
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/task_update', 'c' => $data));
        }

        function action_task_view() {
            $data['task'] = Model_Task::findTask(Uri::segment(4));
            $access = Model_Access::access($_SESSION['user']['role_id']);
            $data['roles'] = Model_Role::accessRoles($access);
            $data['users'] = Model_User::findAll();
            $data['tabs']['customer'] = $this->application['profile']['first_name'].' '.$this->application['profile']['last_name'];
            $data['notes']['notes'] = $this->application['application']['notes'];
            $this->response->body = View::factory('layout', array('l' => 'application/task_view', 'c' => $data));
        }

        function action_task_delete() {
            Model_Task::deleteTask(Uri::segment(4));
            \Notify::success('The task was deleted.');
            header('Location: /application/calendar_day/'.Uri::segment(3));
            exit;
        }
        
        function action_save_notes($app_id){
            Model_Application::update($app_id, $_POST);
        }
    }
