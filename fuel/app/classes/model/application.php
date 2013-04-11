<?php

    class Model_Application {

        // APPLICATIONS
        
        static function update($id, $data){
            $result = DB::update('applications')->set($data)->where('id', '=', $id)->execute();
        }

        static function findApplications($offset = 0, $limit = 25) {
            $sql = "SELECT
                        a.*,
                        u.first_name,
                        u.last_name,
                        u.email,
                        tp.tax_liability,
                        cp.phone_home,
                        cp.phone_work,
                        cp.phone_mobile
                    FROM applications a
                    JOIN users u ON a.user_id = u.id
                    JOIN client_profiles cp ON a.user_id = cp.user_id
                    JOIN client_tax_problem tp ON cp.user_id = tp.user_id
                    WHERE a.completed IS NULL
                    ORDER BY a.priority_level ASC, a.created DESC
                    LIMIT $offset, $limit";
            $result = DB::query($sql, DB::SELECT)->execute();

            if (count($result)) {
                return $result->as_array();
            }
            return array();
        }
        
        static function search($term, $offset = 0, $limit = 25){
            
            $result = DB::select('a.id')
                            ->from(array('applications','a'))
                            ->join(array('users','u'))->on('u.id', '=', 'a.user_id')
                            ->join(array('client_profiles','cp'))->on('cp.user_id', '=', 'a.user_id')
                            ->where('u.first_name', '=', $term)
                            ->or_where('u.last_name', '=', $term)
                            //->or_where('cp.phone_home', '=', preg_replace('/[^0-9]/','',$term))
                            ->or_where('cp.leads360_id', '=', $term)
                            ->execute();
            
            $ids = array();
            foreach($result->as_array() as $row){
                $ids[] = $row['id'];
            }
            
            if(empty($ids)){
                return array();
            }else{
                return self::findByIDs($ids);
            }
            
        }
        
        static function findByFilter($status_id = null, $payment_status = null, $priority = null, $offset = 0, $limit = 25){
            
            $query = DB::select('a.*', 'u.first_name', 'u.last_name', 'u.email', 'tp.tax_liability')
                            ->from(array('applications', 'a'))
                            ->join(array('users', 'u'))->on('u.id', '=', 'a.user_id')
                            ->join(array('client_tax_problem', 'tp'))->on('tp.user_id', '=', 'u.id')
                            ->where('a.completed','is', null)
                            ->order_by('a.priority_level', 'ASC')        
                            ->order_by('a.created', 'DESC')
                            ->offset($offset)
                            ->limit($limit);
            
            if(!empty($status_id)){
                $query->where('a.status_id', '=', $status_id);
            }
            
            if(!empty($payment_status)){
                $query->where('a.payment_status_id', '=', $payment_status);
            }
            
            
            if(!empty($priority)){
                $query->where('a.priority_level', '=', $priority);
            }
            
            $result = $query->execute();
            return $result->as_array();
            
        }

        static function findByIDs($ids) {
            $id_set = implode(',', $ids);
            $sql = "SELECT
                        a.*,
                        u.first_name,
                        u.last_name,
                        u.email,
                        tp.tax_liability,
                        cp.phone_home,
                        cp.phone_work,
                        cp.phone_mobile
                    FROM applications a
                    JOIN users u ON a.user_id = u.id
                    JOIN client_profiles cp ON a.user_id = cp.user_id
                    JOIN client_tax_problem tp ON cp.user_id = tp.user_id
                    WHERE a.completed IS NULL
                    AND a.id IN ($id_set)
                    ORDER BY a.priority_level ASC, a.created DESC";
            $result = DB::query($sql, DB::SELECT)->execute();

            if (count($result)) {
                return $result->as_array();
            }
            return array();
        }

        static function findApplication($id) {
            $sql = "SELECT
                    a.id as a_id, a.user_id as a_user_id, a.sales_rep_id as a_sales_rep_id, a.rep_id as a_rep_id, a.closer_id as a_closer_id, a.current_status as a_current_status,
                    a.status_id as a_status_id, a.payment_status_id as a_payment_status_id, a.priority_level as a_priority_level, a.notes as a_notes, a.application_description as a_application_description, a.appointment_date as a_appointment_date, a.last_action as a_last_action, a.active as a_active,
                    a.created as a_created, a.created_by as a_created_by, a.updated as a_updated, a.updated_by as a_updated_by, a.completed as a_completed,
                    a.completed_by as a_completed_by,

                    u.id as u_user_id, u.first_name as u_first_name, u.middle_name as u_middle_name, u.last_name as u_last_name, u.role_id as u_role_id, u.email as u_email,
                    u.echosign_user_key as u_echosign_user_key, u.created as u_created, u.active as u_active,

                    cp.leads360_id as cp_leads360_id, cp.phone_home as cp_phone_home, cp.phone_work as cp_phone_work, cp.phone_mobile as cp_phone_mobile, cp.phone_fax as cp_phone_fax,
                    cp.best_call_time as cp_best_call_time, cp.address as cp_address, cp.address2 as cp_address2, cp.city as cp_city, cp.state as cp_state, cp.zip as cp_zip,
                    cp.county as cp_county, cp.dob as cp_dob, cp.ssn as cp_ssn, cp.marital_status as cp_marital_status, cp.co_first_name as cp_co_first_name,
                    cp.co_middle_name as cp_co_middle_name, cp.co_last_name as cp_co_last_name, cp.co_phone_home as cp_co_phone_home, cp.co_phone_work as cp_co_phone_work,
                    cp.co_phone_mobile as cp_co_phone_mobile, cp.co_email as cp_co_email, cp.co_dob as cp_co_dob, cp.co_ssn as cp_co_ssn, cp.num_dependents as cp_num_dependents,
                    cp.bank_name as cp_bank_name, cp.bank_branch as cp_bank_branch, cp.bank_routing_number as cp_bank_routing_number, cp.bank_account_number as cp_bank_account_number,
                    cp.cc_name as cp_cc_name, cp.cc_card_type as cp_cc_card_type, cp.cc_exp_date as cp_cc_exp_date, cp.cc_number as cp_cc_number, cp.cc_cvv as cp_cc_cvv,
                    cp.cc_billing_address as cp_cc_billing_address, cp.cc_billing_city as cp_cc_billing_city, cp.cc_billing_state as cp_cc_billing_state, cp.cc_billing_zip as cp_cc_billing_zip,
                    cp.cc_same_as_mailing as cp_cc_same_as_mailing, cp.comments as cp_comments,

                    tp.id as tp_tax_problem_id, tp.tax_type as tp_tax_type, tp.tax_agency as tp_tax_agency, tp.tax_liability as tp_tax_liability, tp.tax_problem as tp_tax_problem, tp.tax_forms as tp_tax_forms,
                    tp.tax_problem_description as tp_tax_problem_description, tp.tax_hardship_description as tp_tax_hardship_description,
                    tp.irs_letter_received as tp_irs_letter_received, tp.lien_mention as tp_lien_mention, tp.certified_mail as tp_certified_mail,
                    tp.letter_description as tp_letter_description, tp.in_fed_payment_plan as tp_in_fed_payment_plan, tp.fed_monthly_payment as tp_fed_monthly_payment,
                    tp.fed_date_plan_started as tp_fed_date_plan_started, tp.in_state_payment_plan as tp_in_state_payment_plan, tp.state_monthly_payment as tp_state_monthly_payment,
                    tp.state_date_plan_started as tp_state_date_plan_started, tp.in_bankruptcy as tp_in_bankruptcy, tp.last_status_irslogics as tp_last_status_irslogics,
                    tp.compliance_closed_date as tp_compliance_closed_date, tp.service_eval_fee as tp_service_eval_fee, tp.service_file_setup_fee as tp_service_file_setup_fee,
                    tp.service_file_service_fee as tp_service_file_service_fee, tp.service_settlement_fee as tp_service_settlement_fee, tp.created as tp_created,
                    tp.created_by as tp_created_by, tp.updated as tp_updated, tp.updated_by as tp_updated_by, tp.bankruptcy_discharge_date as tp_bankruptcy_discharge_date,

                    per.id as per_personal_id, per.inc_wages as per_inc_wages, per.inc_co_income as per_inc_co_income, per.inc_contributions as per_inc_contributions,
                    per.inc_dividends_interest as per_inc_dividends_interest, per.inc_rental as per_inc_rental, per.inc_distributions as per_inc_distributions,
                    per.inc_alimony as per_inc_alimony, per.inc_child_support as per_inc_child_support, per.inc_other_1 as per_inc_other_1, per.inc_other_2 as per_inc_other_2,
                    per.inc_other_3 as per_inc_other_3, per.inc_other_4 as per_inc_other_4, per.asset_cash as per_asset_cash, per.asset_total_bank_accounts as per_asset_total_bank_accounts,
                    per.asset_total_investments as per_asset_total_investments, per.asset_life_insurance as per_asset_life_insurance,
                    per.asset_retirement_accounts as per_asset_retirement_accounts, per.asset_real_estate as per_asset_real_estate, per.asset_vehicle_1 as per_asset_vehicle_1,
                    per.asset_vehicle_2 as per_asset_vehicle_2, per.asset_personal_effects as per_asset_personal_effects, per.asset_other_assets as per_asset_other_assets,
                    per.exp_persons_under_65 as per_exp_persons_under_65, per.exp_persons_over_65 as per_exp_persons_over_65, per.exp_food as per_exp_food,
                    per.exp_housekeeping_supplies as per_exp_housekeeping_supplies, per.exp_apparel as per_exp_apparel, per.exp_personal_care as per_exp_personal_care,
                    per.exp_misc as per_exp_misc, per.exp_first_lien_mortgage as per_exp_first_lien_mortgage, per.exp_second_lien_mortgage as per_exp_second_lien_mortgage,
                    per.exp_rent as per_exp_rent, per.exp_homeowners_insurance as per_exp_homeowners_insurance, per.exp_property_tax as per_exp_property_tax, per.exp_gas as per_exp_gas,
                    per.exp_electric as per_exp_electric, per.exp_water as per_exp_water, per.exp_sewer as per_exp_sewer, per.exp_cable as per_exp_cable, per.exp_trash as per_exp_trash,
                    per.exp_phone as per_exp_phone, per.exp_public_transportation as per_exp_public_transportation, per.exp_first_auto_payment as per_exp_first_auto_payment,
                    per.exp_second_auto_payment as per_exp_second_auto_payment, per.exp_auto_insurance as per_exp_auto_insurance, per.exp_auto_fuel as per_exp_auto_fuel,
                    per.exp_health_insurance as per_exp_health_insurance, per.exp_prescriptions as per_exp_prescriptions, per.exp_copays as per_exp_copays,
                    per.exp_court_ordered_payments as per_exp_court_ordered_payments, per.exp_whole_life_insurance as per_exp_whole_life_insurance,
                    per.exp_term_life_insurance as per_exp_term_life_insurance, per.inc_social_security as per_inc_social_security, per.inc_co_social_security as per_inc_co_social_security,

                    biz.id as biz_business_id, biz.inc_cash as biz_inc_cash, biz.inc_gross_receipts as biz_inc_gross_receipts, biz.inc_rental as biz_inc_rental, biz.inc_interest as biz_inc_interest,
                    biz.inc_dividends as biz_inc_dividends, biz.inc_other_1 as biz_inc_other_1, biz.inc_other_2 as biz_inc_other_2, biz.inc_other_3 as biz_inc_other_3,
                    biz.inc_other_4 as biz_inc_other_4, biz.asset_cash as biz_asset_cash, biz.asset_total_bank_accounts as biz_asset_total_bank_accounts,
                    biz.asset_receivables as biz_asset_receivables, biz.asset_property as biz_asset_property, biz.asset_tools_books as biz_asset_tools_books,
                    biz.asset_other_assets as biz_asset_other_assets, biz.exp_materials as biz_exp_materials, biz.exp_inventory as biz_exp_inventory,
                    biz.exp_gross_wages_salaries as biz_exp_gross_wages_salaries, biz.exp_rent as biz_exp_rent, biz.exp_supplies as biz_exp_supplies,
                    biz.exp_utilities as biz_exp_utilities, biz.exp_gas_oil as biz_exp_gas_oil, biz.exp_maintenance as biz_exp_maintenance, biz.exp_taxes as biz_exp_taxes,
                    biz.exp_other_1 as biz_exp_other_1, biz.exp_other_2 as biz_exp_other_2, biz.exp_other_3 as biz_exp_other_3, biz.exp_other_4 as biz_exp_other_4


                    FROM applications a
                    JOIN users u ON a.user_id = u.id
                    JOIN client_profiles cp ON a.user_id = cp.user_id
                    LEFT JOIN client_tax_problem tp ON cp.user_id = tp.user_id
                    LEFT JOIN client_personal per ON cp.user_id = per.user_id
                    LEFT JOIN client_business biz ON cp.user_id = biz.user_id

                    WHERE a.id = $id";

            $user_id = 0;
            $application = array();
            $app = array();
            $result = DB::query($sql, DB::SELECT)->execute();

            if(count($result)){
                $application = $result->as_array();

                foreach ($application[0] as $k => $v) {
                    $key = explode('_', $k);
                    $ak = $key;
                    $table = $key[0];
                    $category = $key[1];
                    unset($key[0]);
                    $ak = $key;
                    unset($ak[1]);
                    $new_key = implode('_', $key);
                    $alt_key = implode('_', $ak);
                    if ($table == 'a') {
                        if ($new_key == 'user_id') {
                            $user_id = $v;
                        }
                        $app['application'][$new_key] = $v;
                    } else if ($table == 'u') {
                        $app['profile'][$new_key] = $v;
                    } else if ($table == 'cp') {
                        if ($category == 'co') {
                            $app['profile']['spouse'][$alt_key] = $v;
                        } else if ($category == 'bank') {
                            $app['profile']['billing']['bank'][$alt_key] = $v;
                        } else if ($category == 'cc') {
                            $app['profile']['billing']['credit_card'][$alt_key] = $v;
                        } else {
                            $app['profile'][$new_key] = $v;
                        }
                    } else if ($table == 'tp') {
                        if ($category == 'service') {
                            $app['tax_problem']['fees'][$alt_key] = $v;
                        } else {
                            $app['tax_problem'][$new_key] = $v;
                        }
                    } else if ($table == 'per') {
                        if ($category == 'inc') {
                            $app['finances']['personal']['income'][$alt_key] = $v;
                        } else if ($category == 'asset') {
                            $app['finances']['personal']['assets'][$alt_key] = $v;
                        } else if ($category == 'exp') {
                            $app['finances']['personal']['expenses'][$alt_key] = $v;
                        } else {
                            $app['finances']['personal'][$new_key] = $v;
                        }
                    } else if ($table == 'biz') {
                        if ($category == 'inc') {
                            $app['finances']['business']['income'][$alt_key] = $v;
                        } else if ($category == 'asset') {
                            $app['finances']['business']['assets'][$alt_key] = $v;
                        } else if ($category == 'exp') {
                            $app['finances']['business']['expenses'][$alt_key] = $v;
                        } else {
                            $app['finances']['business'][$new_key] = $v;
                        }
                    }
                }

                $sql = "SELECT *
                        FROM client_employment
                        WHERE user_id = $user_id
                        ORDER BY id";

                $result = DB::query($sql, DB::SELECT)->execute();
                if(count($result)){
                    $employment = $result->as_array();
                    foreach($employment as $e) {
                        $app['employment'][$e['id']] = $e;
                    }
                } else {
                    $app['employment'] = array();
                }

                $sql = "SELECT *
                        FROM client_tax_activity
                        WHERE user_id = $user_id
                        ORDER BY year desc";

                $result = DB::query($sql, DB::SELECT)->execute();
                if(count($result)){
                    $activity = $result->as_array();
                    foreach($activity as $a) {
                        $app['tax_activity'][strtolower($a['branch'])][$a['year']] = $a;
                    }
                } else {
                    $app['tax_activity'] = array();
                }

                $sql = "SELECT *
                        FROM application_payments
                        WHERE application_id = $id
                        ORDER BY payment_number";

                $result = DB::query($sql, DB::SELECT)->execute();
                if(count($result)){
                    $payments = $result->as_array();
                    foreach($payments as $p) {
                        $app['payments'][$p['payment_number']] = $p;
                    }
                } else {
                    $app['payments'] = array();
                }
                return $app;
            } else {
                throw new Exception('Could not find contract');
            }

        }

        // PROFILE

        static function updateProfile($values) {
            if (isset($values['first_name'])) {
                $user_fields = array(
                    'first_name' => $values['first_name'],
                    'middle_name' => $values['middle_name'],
                    'last_name' => $values['last_name'],
                    'email' => $values['email'],
                );
                $result = DB::update('users')
                            ->set($user_fields)
                            ->where('id', '=', $values['user_id'])
                            ->execute();

                unset($values['first_name']);
                unset($values['middle_name']);
                unset($values['last_name']);
                unset($values['email']);
            }
            $result = DB::update('client_profiles')
                        ->set($values)
                        ->where('user_id', '=', $values['user_id'])
                        ->execute();
            return true;
        }

        // EMPLOYMENT

        static function insertEmployment($values) {
            \DB::insert('client_employment')->set($values)->execute();
            return true;
        }

        static function updateEmployment($values) {
            $emp_id = $values['employment_id'];
            unset($values['employment_id']);

            $result = DB::update('client_employment')
                        ->set($values)
                        ->where('id', '=', $emp_id)
                        ->execute();
            return true;
        }

        // PERSONAL

        static function insertPersonal($values) {
            \DB::insert('client_personal')->set($values)->execute();
            return true;
        }

        static function updatePersonal($values) {
            $per_id = $values['personal_id'];
            unset($values['personal_id']);

            $result = DB::update('client_personal')
                        ->set($values)
                        ->where('id', '=', $per_id)
                        ->execute();
            return true;
        }

        // BUSINESS FINANCES

        static function insertBusiness($values) {
            \DB::insert('client_business')->set($values)->execute();
            return true;
        }

        static function updateBusiness($values) {
            $biz_id = $values['business_id'];
            unset($values['business_id']);

            $result = DB::update('client_business')
                        ->set($values)
                        ->where('id', '=', $biz_id)
                        ->execute();
            return true;
        }

        // TAX PROBLEM

        static function insertTaxProblem($values) {
            \DB::insert('client_tax_problem')->set($values)->execute();
            return true;
        }

        static function updateTaxProblem($values) {
            $prob_id = $values['tax_problem_id'];
            unset($values['tax_problem_id']);

            $result = DB::update('client_tax_problem')
                        ->set($values)
                        ->where('id', '=', $prob_id)
                        ->execute();
            return true;
        }
        
        static function insertTaxActivity($values) {
            \DB::insert('client_tax_activity')->set($values)->execute();
            return true;
        }

        static function updateTaxActivity($values) {
            $id = $values['id'];
            unset($values['id']);

            $result = DB::update('client_tax_activity')
                        ->set($values)
                        ->where('id', '=', $id)
                        ->execute();
            return true;
        }

        // PAYMENTS

        static function insertPayment($values) {
            \DB::insert('application_payments')->set($values)->execute();
            return true;
        }

        static function updatePayment($values) {
            $id = $values['id'];
            unset($values['id']);

            $result = DB::update('application_payments')
                        ->set($values)
                        ->where('id', '=', $id)
                        ->execute();
            return true;
        }

        // SERVICE TYPES

        static function findServiceTypes($service=1){

            $result = DB::select('*')
                      ->from('service_types')
                      ->where('service_id', $service)
                      ->execute();

            if(count($result)){
                $service_types = $result->as_array();
                return $service_types;
            }

            throw New Exception('Service Types Failed');

        }

        // NOTES

        static function findNotes($app_id){

            $resp = array();
            $result = DB::select('application_notes.*')
                      ->select('users.first_name', 'users.last_name')
                      ->from('application_notes')
                      ->join('users')
                      ->on('application_notes.created_by', '=', 'users.id')
                      ->where('application_notes.application_id', $app_id)
                      ->order_by('application_notes.created', 'desc')
                      ->execute();

            if(count($result)){
                $resp = $result->as_array();
                return $resp;
            } else {
                return $resp;
            }

            throw New Exception('Unable to get notes');

        }

        static function add_note($data) {

            \DB::insert('application_notes')->set($data)->execute();
            return true;

        }
        
        static function countAll(){
            
            $result = DB::select(DB::expr('count(id) as total_items'))->from('applications')->where('active', '=', 1)->execute();
            $row = current($result->as_array());
            return $row['total_items']; 
        }

    }
