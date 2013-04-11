<?php

    class Controller_Import extends Controller_Base{
        
        function before(){
            parent::before();
            if(!in_array($_SESSION['user']['id'], array(1,2))){
                print 'must be superadmin';exit;
            }
        }
        
        protected $import_path = '/var/www/devcrm/import/';
        
        function action_five9($csv_filename){
            
            set_time_limit(7200);
            
            $file = fopen($this->import_path.$csv_filename, 'r');
            
            if($file !== false){
                while (($record = fgetcsv($file)) !== false){

                    $case = array(
                                  'primary_phone' => $record[0],
                                  'secondary_phone' => $record[1],
                                  'mobile_phone' => $record[2],
                                  'first_name' => $record[3],
                                  'last_name' => $record[4],
                                  'status' => $record[10],
                                  'campaign' => $record[11],
                                  'leads360_id' => $record[12]
                                 );

                    Model_Import::caseImport($case);

                }
            }
            
            fclose($file);
            
            $errors = Model_Import::getErrors();
            
            if(!empty($errors)){
                $error_log = fopen($this->import_path.'errors_'.substr(time(),0,5).'_'.$csv_filename, 'w+');
                foreach($errors as $e){
                    fputcsv($error_log, $e);
                }
                fclose($error_log);
            }
        }

        function action_activity($csv_filename, $run=0) {
            set_time_limit(3600);
            $row = 1;
            $file = fopen($this->import_path.$csv_filename, 'r');

            if (!$run) {
                echo '<p>Running in test mode</p>';
            }
            
            if($file !== false){
                while (($data = fgetcsv($file)) !== FALSE) {
                    if ($data[0] == 'Id' || !strlen($data[0])) {
                        $row++;
                        continue;
                    }

                    $activity = array(
                        'case_id' => (integer)$data[0],
                        'message' => $data[2],
                        'note' => $data[4],
                        'type' => 'action',
                        'by' => 0,
                        'user' => $data[3],
                        'ts' => date('Y-m-d H:i:s', strtotime($data[1]))
                    );
                    if ($run) {
                        Model_Import::activityImport($activity);
                        DB::update('cases')->set(array('action_count' => DB::expr('action_count + 1'), 'last_action' => date('Y-m-d H:i:s', strtotime($data[1]))))->where('id', '=', $data[0])->execute();
                        echo 'Activity for '.$data[0].' processed<br/>';
                    } else {
                        echo '<p>';
                        echo '<pre>';
                        print_r($activity);
                        echo '</pre>';
                        echo '</p>';
                    }
                    $row++;
                }
            }

            fclose($file);
            $this->_write_errors(Model_Import::getErrors(), $csv_filename);
        }

        function action_payment($csv_filename, $run=0) {
            set_time_limit(3600);
            $row = 1;
            $file = fopen($this->import_path.$csv_filename, 'r');

            if (!$run) {
                echo '<p>Running in test mode</p>';
            }

            if($file !== false){
                while (($data = fgetcsv($file)) !== FALSE) {
                    if ($data[0] == 'Id' || !strlen($data[0])) {
                        $row++;
                        continue;
                    }

                    // format date added
                    $date_added = date('Y-m-d H:i:s');
                    if (isset($data[32]) && strlen($data[32])) {
                        $date_added = date('Y-m-d H:i:s', strtotime($data[32]));
                    }

                    $base_date = 217;
                    $base_payment = 218;
                    $base_auth = 219;

                    for($i=1;$i<13;$i++) {

                        $payment = array();

                        if ($i > 1) {
                            $base_date = $base_date + 3;
                            $base_payment = $base_payment + 3;
                            $base_auth = $base_auth + 3;
                        }

                        if (strlen($data[$base_payment]) && $data[$base_payment] > 0) {

                            $payment = array(
                                'case_id' => (integer)$data[0],
                                'amount' => (float)$data[$base_payment],
                                'status' => 'pending',
                                'date_due' => date('Y-m-d 00:00:00', strtotime($data[$base_date])),
                                'creator' => $data[31],
                                'created' => $date_added,
                                'created_by' => 0,
                                'updater' => $data[31],
                                'updated' => $date_added,
                                'updated_by' => 0
                            );

                            if (strlen($data[$base_auth])) {
                                $payment['received_note'] = 'Authorization: '.$data[$base_auth];
                                $payment['status'] = 'paid';
                            }

                            if ($run) {
                                Model_Import::paymentImport($payment);
                                echo 'Payment '.$i.' for '.$data[0].' processed<br/>';
                            } else {
                                echo '<p>';
                                echo '<pre>';
                                print_r($payment);
                                echo '</pre>';
                                echo '</p>';
                            }
                        }
                    }

                    $row++;
                }
            }

            fclose($file);
            $this->_write_errors(Model_Import::getErrors(), $csv_filename);
        }

        function action_case($csv_filename, $run=0) {
            set_time_limit(3600);
            $row = 1;
            $file = fopen($this->import_path.$csv_filename, 'r');

            if (!$run) {
                echo '<p>Running in test mode - first 30 records</p>';
            }

            if($file !== false){
                while (($data = fgetcsv($file)) !== FALSE) {
                    if ($data[0] == 'Id' || !strlen($data[0])) {
                        $row++;
                        continue;
                    }

                    // format date added
                    $date_added = date('Y-m-d H:i:s');
                    if (isset($data[32]) && strlen($data[32])) {
                        $date_added = date('Y-m-d H:i:s', strtotime($data[32]));
                    }

                    // fix phones
                    $primary_phone = $data[42];
                    if (!strlen($primary_phone)) {
                        if (strlen($data[52])) {
                            $primary_phone = $data[52];
                            $data[52] = '';
                        } else if (strlen($data[43])) {
                            $primary_phone = $data[43];
                            $data[43] = '';
                        }
                    }

                    // format compliance
                    $compliance_call_appointment = date('Y-m-d H:i:s');
                    if (isset($data[55]) && strlen($data[55])) {
                        $compliance_call_appointment = date('Y-m-d H:i:s', strtotime($data[32]));
                    }

                    // merge tax problem notes
                    $notes = '';
                    if (isset($data[50]) && strlen($data[50])) {
                        $notes .= $data[50];
                    }
                    if (isset($data[51]) && strlen($data[51])) {
                        $notes .= "\n".$data[51];
                    }

                    // calculate total fees
                    $total_fees = 0;
                    if (isset($data[213]) && strlen($data[213]) && is_numeric($data[213])) {
                        $total_fees += $data[213];
                    }
                    if (isset($data[214]) && strlen($data[214]) && is_numeric($data[214])) {
                        $total_fees += $data[214];
                    }
                    if (isset($data[215]) && strlen($data[215]) && is_numeric($data[215])) {
                        $total_fees += $data[215];
                    }
                    if (isset($data[216]) && strlen($data[216]) && is_numeric($data[216])) {
                        $total_fees += $data[216];
                    }

                    // format fed and state tax statuses
                    $federal_not_filed = array();
                    $federal_owed = array();
                    $state_not_filed = array();
                    $state_owed = array();

                    // federal not filed
                    $fnf = array(
                                 147 => 2011, 149 => 2010, 151 => 2009, 153 => 2008, 155 => 2007, 
                                 157 => 2006, 159 => 2005, 161 => 2004, 163 => 2003, 165 => 2002,
                                 167 => 2001, 169 => 2000
                                );
                    
                    foreach($fnf as $k => $v){
                        if (isset($data[$k]) && strlen($data[$k]) && strtolower($data[$k]) != 'false') {
                            $federal_not_filed[] = $v;
                        }
                    }
                    /*
                    if (isset($data[147]) && strlen($data[147]) && $data[147] != 'False') {
                        $federal_not_filed[] = 2011;
                    }
                    if (isset($data[149]) && strlen($data[149]) && $data[149] != 'False') {
                        $federal_not_filed[] = 2010;
                    }
                    if (isset($data[151]) && strlen($data[151]) && $data[151] != 'False') {
                        $federal_not_filed[] = 2009;
                    }
                    if (isset($data[153]) && strlen($data[153]) && $data[153] != 'False') {
                        $federal_not_filed[] = 2008;
                    }
                    if (isset($data[155]) && strlen($data[155]) && $data[155] != 'False') {
                        $federal_not_filed[] = 2007;
                    }
                    if (isset($data[157]) && strlen($data[157]) && $data[157] != 'False') {
                        $federal_not_filed[] = 2006;
                    }
                    if (isset($data[159]) && strlen($data[159]) && $data[159] != 'False') {
                        $federal_not_filed[] = 2005;
                    }
                    if (isset($data[161]) && strlen($data[161]) && $data[161] != 'False') {
                        $federal_not_filed[] = 2004;
                    }
                    if (isset($data[163]) && strlen($data[163]) && $data[163] != 'False') {
                        $federal_not_filed[] = 2003;
                    }
                    if (isset($data[165]) && strlen($data[165]) && $data[165] != 'False') {
                        $federal_not_filed[] = 2002;
                    }
                    if (isset($data[167]) && strlen($data[167]) && $data[167] != 'False') {
                        $federal_not_filed[] = 2001;
                    }
                    if (isset($data[169]) && strlen($data[169]) && $data[169] != 'False') {
                        $federal_not_filed[] = 2000;
                    }
                    */
                    
                    $fo = array(
                                148 => 2011, 150 => 2010, 152 => 2009, 154 => 2008, 156 => 2007,
                                158 => 2006, 160 => 2005, 162 => 2004, 164 => 2003, 166 => 2002,
                                168 => 2001, 170 => 2000
                               );
                    
                    foreach($fo as $k => $v){
                        if (isset($data[$k]) && strlen($data[$k]) && strtolower($data[$k]) != 'false') {
                            $federal_owed[] = $v;
                        }
                    }
                    /*
                    // federal owed
                    if (isset($data[148]) && strlen($data[148]) && $data[148] != 'False') {
                        $federal_owed[] = 2011;
                    }
                    if (isset($data[150]) && strlen($data[150]) && $data[150] != 'False') {
                        $federal_owed[] = 2010;
                    }
                    if (isset($data[152]) && strlen($data[152]) && $data[152] != 'False') {
                        $federal_owed[] = 2009;
                    }
                    if (isset($data[154]) && strlen($data[154]) && $data[154] != 'False') {
                        $federal_owed[] = 2008;
                    }
                    if (isset($data[156]) && strlen($data[156]) && $data[156] != 'False') {
                        $federal_owed[] = 2007;
                    }
                    if (isset($data[158]) && strlen($data[158]) && $data[158] != 'False') {
                        $federal_owed[] = 2006;
                    }
                    if (isset($data[160]) && strlen($data[160]) && $data[160] != 'False') {
                        $federal_owed[] = 2005;
                    }
                    if (isset($data[162]) && strlen($data[162]) && $data[162] != 'False') {
                        $federal_owed[] = 2004;
                    }
                    if (isset($data[164]) && strlen($data[164]) && $data[164] != 'False') {
                        $federal_owed[] = 2003;
                    }
                    if (isset($data[166]) && strlen($data[166]) && $data[166] != 'False') {
                        $federal_owed[] = 2002;
                    }
                    if (isset($data[168]) && strlen($data[168]) && $data[168] != 'False') {
                        $federal_owed[] = 2001;
                    }
                    if (isset($data[170]) && strlen($data[170]) && $data[170] != 'False') {
                        $federal_owed[] = 2000;
                    }
                    */
                    
                    $snf = array(
                                  171 => 2011, 173 => 2010, 175 => 2009, 177 => 2008, 179 => 2007,
                                  181 => 2006, 183 => 2005, 185 => 2004, 187 => 2003, 189 => 2002,
                                  191 => 2001, 193 => 2000
                                );
                    
                    foreach($snf as $k => $v){
                        if (isset($data[$k]) && strlen($data[$k]) && strtolower($data[$k]) != 'false') {
                            $federal_owed[] = $v;
                        }
                    }
                    /*
                    // state not filed
                    if (isset($data[171]) && strlen($data[171]) && $data[171] != 'False') {
                        $state_not_filed[] = 2011;
                    }
                    if (isset($data[173]) && strlen($data[173]) && $data[173] != 'False') {
                        $state_not_filed[] = 2010;
                    }
                    if (isset($data[175]) && strlen($data[175]) && $data[175] != 'False') {
                        $state_not_filed[] = 2009;
                    }
                    if (isset($data[177]) && strlen($data[177]) && $data[177] != 'False') {
                        $state_not_filed[] = 2008;
                    }
                    if (isset($data[179]) && strlen($data[179]) && $data[179] != 'False') {
                        $state_not_filed[] = 2007;
                    }
                    if (isset($data[181]) && strlen($data[181]) && $data[181] != 'False') {
                        $state_not_filed[] = 2006;
                    }
                    if (isset($data[183]) && strlen($data[183]) && $data[183] != 'False') {
                        $state_not_filed[] = 2005;
                    }
                    if (isset($data[185]) && strlen($data[185]) && $data[185] != 'False') {
                        $state_not_filed[] = 2004;
                    }
                    if (isset($data[187]) && strlen($data[187]) && $data[187] != 'False') {
                        $state_not_filed[] = 2003;
                    }
                    if (isset($data[189]) && strlen($data[189]) && $data[189] != 'False') {
                        $state_not_filed[] = 2002;
                    }
                    if (isset($data[191]) && strlen($data[191]) && $data[191] != 'False') {
                        $state_not_filed[] = 2001;
                    }
                    if (isset($data[193]) && strlen($data[193]) && $data[193] != 'False') {
                        $state_not_filed[] = 2000;
                    }
                    */
                    
                    $so = array(
                                172 => 2011, 174 => 2010, 176 => 2009, 178 => 2008, 180 => 2007,
                                182 => 2006, 184 => 2005, 186 => 2004, 188 => 2003, 190 => 2002,
                                192 => 2001, 194 => 2000
                               );
                    
                    foreach($so as $k => $v){
                        if (isset($data[$k]) && strlen($data[$k]) && strtolower($data[$k]) != 'false') {
                            $federal_owed[] = $v;
                        }
                    }
                    /*
                    // state owed
                    if (isset($data[172]) && strlen($data[172]) && $data[172] != 'False') {
                        $state_owed[] = 2011;
                    }
                    if (isset($data[174]) && strlen($data[174]) && $data[174] != 'False') {
                        $state_owed[] = 2010;
                    }
                    if (isset($data[176]) && strlen($data[176]) && $data[176] != 'False') {
                        $state_owed[] = 2009;
                    }
                    if (isset($data[178]) && strlen($data[178]) && $data[178] != 'False') {
                        $state_owed[] = 2008;
                    }
                    if (isset($data[180]) && strlen($data[180]) && $data[180] != 'False') {
                        $state_owed[] = 2007;
                    }
                    if (isset($data[182]) && strlen($data[182]) && $data[182] != 'False') {
                        $state_owed[] = 2006;
                    }
                    if (isset($data[184]) && strlen($data[184]) && $data[184] != 'False') {
                        $state_owed[] = 2005;
                    }
                    if (isset($data[186]) && strlen($data[186]) && $data[186] != 'False') {
                        $state_owed[] = 2004;
                    }
                    if (isset($data[188]) && strlen($data[188]) && $data[188] != 'False') {
                        $state_owed[] = 2003;
                    }
                    if (isset($data[190]) && strlen($data[190]) && $data[190] != 'False') {
                        $state_owed[] = 2002;
                    }
                    if (isset($data[192]) && strlen($data[192]) && $data[192] != 'False') {
                        $state_owed[] = 2001;
                    }
                    if (isset($data[194]) && strlen($data[194]) && $data[194] != 'False') {
                        $state_owed[] = 2000;
                    }   
                    */
                    
                    $case = array(
                        'sales_rep' => $data[31],
                        'sales_rep_id' => 0,
                        'irs_logics_ref_id' => $data[33],
                        'closer_rep' => $data[197],
                        'closer_id' => 0,
                        'created' => $date_added,
                        'status' => $data[30],
                        'notes' => '',
                        'campaign' => $data[29],
                        'first_name' => $data[34],
                        'middle_name' => $data[35],
                        'last_name' => $data[36],
                        'primary_phone' => $primary_phone,
                        'secondary_phone' => $data[52],
                        'mobile_phone' => $data[43],
                        'email' => $data[44],
                        'address' => $data[37],
                        'address_2' => $data[38],
                        'city' => $data[39],
                        'state' => $data[40],
                        'zip' => $data[41],
                        'dob' => $data[45],
                        'ssn' => $data[46],
                        'federal_tax_liability' => $data[47],
                        'state_tax_liability' => $data[48],
                        'total_tax_liability' => $data[47]+$data[48],
                        //'tax_problem_description' => $tax_problem_description,
                        'notes' => $notes,
                        'fax' => $data[53],
                        'preferred_call_time' => $data[54],
                        'compliance_call_appointment' => date('m/d/Y g:ia', strtotime($compliance_call_appointment)),
                        'timezone' => $this->convertTimezone($data[28]),
                        'employment' => $data[56],
                        'occupation' => $data[57],
                        'type_of_work' => $data[59],
                        'occupational_status' => $data[58],
                        'business_type' => $data[61],
                        'business_name' => $data[60],
                        'employer_id_number' => $data[62],
                        'business_taxes' => $data[63],
                        'marital_filing_status' => $data[64],
                        'spouse_first_name' => $data[65],
                        'spouse_middle_initial' => $data[66],
                        'spouse_last_name' => $data[67],
                        'spouse_ssn' => $data[69],
                        'spouse_dob' => $data[68],
                        'spouse_email' => $data[70],
                        'spouse_primary_phone' => $data[71],
                        'spouse_secondary_phone' => $data[72],
                        'spouse_mobile_phone' => $data[73],
                        'how_many_dependents' => $data[74],
                        'tax_problem' => $data[78],
                        'tax_type' => $data[76],
                        'leads360_id' => $data[0],
                        'tax_agency' => $data[77],
                        'form_numbers' => $data[79],
                        'did_you_receive_a_letter_in_the_mail' => $this->parseYesNo($data[80]),
                        'is_there_any_mention_of_a_lien' => $this->parseYesNo($data[81]),
                        'was_it_a_certified_letter' => $this->parseYesNo($data[82]),
                        'what_exactly_did_the_letter_say' => $data[83],
                        'are_you_currently_in_an_irs_payment_plan' => $this->parseYesNo($data[84]),
                        'how_much_is_your_monthly_irs_payment' => $data[85],
                        'when_did_the_irs_plan_start' => $this->parseDate($data[86]),
                        'are_you_currently_in_a_state_payment_plan' => $this->parseYesNo($data[87]),
                        'how_much_is_your_monthly_state_payment' => $data[88],
                        'when_did_the_state_plan_start' => $this->parseDate($data[89]),
                        'are_you_currently_in_bankruptcy' => $this->parseYesNo($data[90]),
                        'if_yes_what_is_the_discharge_date' => $this->parseDate($data[91]),
                        'cash_on_hand' => $data[94],
                        'bank_accounts' => $data[95],
                        'investments' => $data[96],
                        'life_insurance' => $data[97],
                        'retirement_account' => $data[98],
                        'real_estate' => $data[99],
                        'vehicle_1' => $data[100],
                        'vehicle_2' => $data[101],
                        'personal_effects' => $data[102],
                        'other_assets' => $data[103],
                        'monthly_gross_income_wages' => $data[104],
                        'spouse_monthly_gross_income' => $data[105],
                        'contribution_income' => $data[106],
                        'dividends-interest' => $data[107],
                        'rental_income' => $data[108],
                        'distributions_k-1' => $data[109],
                        'social_security_taxpayer' => $data[110],
                        'social_security_spouse' => $data[111],
                        'alimony' => $data[112],
                        'child_support' => $data[113],
                        'other_rent_subsidy_oil_credit_etc' => $data[114],
                        'other_income' => $data[115],
                        'other_income_2' => $data[116],
                        'persons_under_age_65' => $data[117],
                        'persons_age_65_or_older' => $data[118],
                        'food' => $data[119],
                        'apparel' => $data[120],
                        'personal_care' => $data[121],
                        'miscellaneous' => $data[122],
                        '1st_lien_mortgage' => $data[123],
                        '2nd_lien_mortgage' => $data[124],
                        'morgage_or_rent_payment' => $data[125],
                        'homeowners_insurance' => $data[126],
                        'property_tax' => $data[127],
                        'electricity' => $data[128],
                        'trash' => $data[129],
                        'phone' => $data[130],
                        'cable' => $data[131],
                        'sewer' => $data[132],
                        'water' => $data[133],
                        'gas' => $data[134],
                        'housekeeping_supplies' => $data[135],
                        'public_transportation' => $data[136],
                        'auto_ownershiplease_costs_1' => $data[137],
                        'auto_ownershiplease_costs_2' => $data[138],
                        'auto_insurance' => $data[139],
                        'gasoline' => $data[140],
                        'health_insurance' => $data[141],
                        'prescriptions' => $data[142],
                        'copays' => $data[143],
                        'court_ordered_payments' => $data[144],
                        'whole_life_insurance_policy' => $data[145],
                        'term_life_insurance_policy' => $data[146],
                        'federal_not_filed' => $federal_not_filed,
                        'federal_owed' => $federal_owed,
                        'state_owed' => $state_not_filed,
                        'state_not_filed' => $state_owed,
                        'business_cash_on_hand' => $data[254],
                        'business_cash_in_banks' => $data[255],
                        'receivables' => $data[256],
                        'properties' => $data[257],
                        'tools_and_books' => $data[258],
                        'business_other_assets' => $data[259],
                        'gross_receipts' => $data[260],
                        'gross_rental_income' => $data[261],
                        'interest' => $data[262],
                        'dividends' => $data[263],
                        'business_cash_income' => $data[264],
                        'business_other_income_1' => $data[265],
                        'business_other_income_2' => $data[266],
                        'business_other_income_3' => $data[267],
                        'business_other_income_4' => $data[268],
                        'materials_purchased' => $data[269],
                        'inventory_purchased' => $data[270],
                        'gross_wages_and_salary' => $data[271],
                        'business_rent' => $data[272],
                        'supplies' => $data[273],
                        'utilitiestelephone' => $data[274],
                        'business_vehicle_gasolineoil' => $data[275],
                        'business_repairs_and_maintenance' => $data[276],
                        'business_insurance' => $data[277],
                        'business_current_taxes' => $data[278],
                        'business_other_expense_1' => $data[279],
                        'business_other_expense_2' => $data[280],
                        'business_other_expense_3' => $data[281],
                        'business_other_expense_4' => $data[282],
                        'total_fees' =>	$total_fees,
                        'case_evaluation_fee' => $data[213],
                        'tax_file_setup_fee' => $data[214],
                        'tax_return_filing_services_fee' => $data[215],
                        'tax_settlement_services_fee' => $data[216],
                        'bank_name' => $data[198],
                        'bank_branch' => $data[199],
                        'bank_account_number' => $data[200],
                        'bank_routing_number' => $data[201],
                        'credit_card_type' => $data[202],
                        'name_on_credit_card' => $data[203],
                        'credit_card_number' => $data[205],
                        'credit_card_expiration_date' => $data[206],
                        'security_number_on_cards_back' => $data[207],
                        'billing_address_same_as_mailing_address' => $this->parseYesNo($data[204]),
                        'billing_address_1' => $data[208],
                        'billing_address_2' => $data[209],
                        'billing_city' => $data[210],
                        'billing_state' => $data[211],
                        'billing_zip_code' => $data[212]
                    );

                    if ($run) {
                        Model_Import::caseImport($case);
                        echo $data[0].' attempted<br/>';
                    } else {
                        if ($row > 30) {
                            break;
                        }
                        echo '<p>';
                        echo '<pre>';
                        print_r($case);
                        echo '</pre>';
                        echo '</p>';
                    }
                    
                    $row++;
                }
            }

            fclose($file);
            $this->_write_errors(Model_Import::getErrors(), $csv_filename);
        }

        function _write_errors($errors, $csv_filename) {
            if(!empty($errors)){
                $error_log = fopen($this->import_path.'errors_'.substr(time(),0,5).'_'.$csv_filename, 'w+');
                foreach($errors as $e){
                    fputcsv($error_log, $e);
                }
                fclose($error_log);
            }
        }
        
        function parseDate($date, $format = 'm/d/Y'){
            
            $t = strtotime($date);
            
            if(!$t){
                return '';
            }
            
            if(date('Y', $t) == 1900){
                return '';
            }
            
            return date($format, $t);
            
        }
        
        function parseYesNo($v){
            
            if(strtolower($v) == 'false'){
                return 0;
            }elseif(strtolower($v) == 'true'){
                return 1;
            }
            
            return '';
            
        }
        
        function convertTimezone($tz){
            
            $tz = trim($tz);
            
            if($tz == 'Central Time (US & Canada)'){
                return 'Central';
            }elseif($tz == 'Eastern Time (US & Canada)'){
                return 'Eastern';
            }elseif($tz == 'Pacific Time (US & Canada)'){
                return 'Pacific';
            }elseif($tz == 'Mountain Time (US & Canada)'){
                return 'Mountain';
            }
            
            return '';
            
        }
        
    }