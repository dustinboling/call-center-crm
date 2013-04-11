<?php

    class Model_Payment extends Model{
        
        static function find($case_id, $id){
            $result = DB::select()->from('payments')->where('case_id', '=', $case_id)->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            return array();
        }
        
        static function findByCaseID($case_id){
            $result = DB::select()->from('payments')->where('case_id', '=', $case_id)->execute();
            return $result->as_array();
        }
        
        static function findNextPayment($case_id){
            $result = DB::select()->from('payments')->where('case_id', '=', $case_id)->where('status', 'in', array('pending','processing','hold'))->order_by('date_due')->limit(1)->execute();
            return current($result->as_array());
        }
        
        static function update($case_id, $id, $data){
            
            if(isset($data['date_due'])){
                $data['date_due'] = date('Y-m-d H:i:s', strtotime($data['date_due']));
            }
            
            DB::update('payments')->set($data)->where('id', '=', $id)->where('case_id', '=', $case_id)->execute();
        }
        
        static function resetPaymentPlan($case_id){
            $result = DB::delete('payments')->where('case_id', '=', $case_id)->where('status', 'not in', array('paid','processing','NSF'))->execute();
        }
        
        static function getTotalPayments($case_id, $all_scheduled = false){
            
            $query = DB::select('id', 'amount')->from('payments')->where('case_id', '=', $case_id);
            
            if($all_scheduled){
                $query->where('status','not in',array('NSF','paid'));
            }else{
                $query->where('status','=','paid');
            }
            
            $result = $query->execute();
            
            $payments = array();
            foreach($result->as_array() as $p){
                $payments[] = $p['amount'];
            }
            
            return array_sum($payments);
            
        }
        
        static function getLastPendingDate($case_id){
            
            $result = DB::select('date_due')->from('payments')->where('case_id', '=', $case_id)->where('status', '=', 'pending')->order_by('date_due','desc')->execute();
            $row = current($result->as_array());
            return $row['date_due'];
            
        }
        
        static function process($case_id, $data){
            
            $payment = array(
                            'status' => $data['status'],
                            'amount_received' => $data['amount_received'],
                            'received_by' => $_SESSION['user']['id'],
                            'date_received' => date('Y-m-d H:i:s'),
                            'received_note' => $data['received_note'],
                            'updated' => date('Y-m-d H:i:s'),
                            'updated_by' => $_SESSION['user']['id']                                    
                           );
            
            if(!isset($data['id']) || empty($data['id'])){
                
                $add = array(
                            'case_id' => $case_id,
                            'amount' => $data['amount_received'],
                            'date_due' => date('Y-m-d'),
                            'created' => date('Y-m-d H:i:s'),
                            'created_by' => $_SESSION['user']['id']
                           );
                
                $new = array_merge($payment, $add);
                
                DB::insert('payments')->set($new)->execute();
                
            }else{
                DB::update('payments')->set($payment)->where('id', '=', $data['id'])->where('case_id', '=', $case_id)->execute();
            }
            
        }
        
        static function generatePaymentPlan($data){
            
            $minimum_payment_amount = 25;
            
            $payments_made = self::getTotalPayments($data['case_id']);
            $payments_scheduled = self::getTotalPayments($data['case_id'], true);
            $total_payments_due = Model_Case::getTotalFees($data['case_id']) - ($payments_made + $payments_scheduled);
            
            if($total_payments_due == 0){
                throw new Exception('Payments are already scheduled for the entire balance due');
            }
            
            if($data['generate_by'] == 'number'){
                $payments_amount = $total_payments_due / $data['number_payments'];
            }else{
                $payments_amount = $data['payment_amount'];
                $data['number_payments'] = ceil($total_payments_due / $payments_amount);
            }
            
            $payments = array();

            $last_payment = false;
            $sch_payments = array();
            $last_pending_payment_date = self::getLastPendingDate($data['case_id']);
            $start_date = (empty($last_pending_payment_date)?$data['start_date']:$last_pending_payment_date);
            $date_due = date('Y-m-d', strtotime($start_date));
            
            for($i=1;$i<=$data['number_payments'];$i++){
                
                if($i>1 || !empty($last_pending_payment_date)){
                    $date_due = date('Y-m-d', strtotime('+'.$data['payment_frequency'], strtotime($date_due)));
                }
                
                $next_period_due = $total_payments_due-(array_sum($sch_payments)+$payments_amount);

                if($next_period_due < $minimum_payment_amount){
                    $last_payment = true;
                }elseif($i==$data['number_payments']){
                    $last_payment = true;
                }
                
                $payment = array(
                                    'case_id' => $data['case_id'],
                                    'amount' => ($last_payment?$total_payments_due-array_sum($sch_payments):$payments_amount),
                                    'date_due' => $date_due,
                                    'created' => date('Y-m-d H:i:s'),
                                    'created_by' => $_SESSION['user']['id'],
                                    'updated' => date('Y-m-d H:i:s'),
                                    'updated_by' => $_SESSION['user']['id']                                    
                                );
                
                DB::insert('payments')->set($payment)->execute();
                
                if($last_payment){
                    return;
                }
                
                $sch_payments[] = $payments_amount;
            }
            
        }
        
        static function getPaymentPlanSummary($case_id){
            
            $payments_res = DB::select('amount')->from('payments')->where('case_id', '=', $case_id)->order_by('date_due')->execute();
            
            $payments = $payments_res->as_array();
            
            $result = DB::select(DB::expr('MIN(date_due) as pay_start_date'), DB::expr('MAX(date_due) as pay_end_date'), DB::expr('COUNT(id) as pay_payments'))
                    ->from('payments')
                    ->where('case_id', '=', $case_id)
                    ->group_by('case_id')
                    ->execute();
            
            $plan = current($result->as_array());
            
            $i = 1;
            foreach($payments as $p){
                $plan['pay_payment_amount'.$i] = $p['amount'];
                $i++;
            }
            
            $plan['pay_total_payments'] = count($payments);
            
            if($plan['pay_payments'] == 0){
                $plan['pay_schedule'] = null;
                return $plan;
            }
            
            $start_date = new DateTime($plan['pay_start_date']);
            $end_date = new DateTime($plan['pay_end_date']);
            
            if(!empty($plan['pay_start_date'])){
                $plan['pay_start_date'] = date('m/d/Y', strtotime($plan['pay_start_date']));
            }
            
            if(!empty($plan['pay_end_date'])){
                $plan['pay_end_date'] = date('m/d/Y', strtotime($plan['pay_end_date']));
            }
            
            $month_test = clone $start_date;
            $month_test->modify('+'.($plan['pay_payments']-1).' Months');

            $seconds = $end_date->getTimestamp() - $start_date->getTimestamp();
            $weeks = round($seconds / 60 / 60 / 24 / 7)+1;

            if($month_test->format('Y-m-d') == $end_date->format('Y-m-d')){
                $plan['pay_schedule'] = 'Monthly';
            }elseif($plan['pay_payments'] == $weeks){
                $plan['pay_schedule'] = 'Weekly';
            }else{
                $plan['pay_schedule'] = 'Bimonthly';
            }

            return $plan;
        }
        
    }