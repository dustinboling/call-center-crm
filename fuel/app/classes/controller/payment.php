<?php
    
    class Controller_Payment extends Controller_Base{
        
        function action_listing($case_id){
            
        }
        
        function action_manage($case_id){

            if(!empty($_POST)){
                
                if(isset($_POST['generate'])){
                    $_POST['case_id'] = $case_id;
                    Model_Payment::generatePaymentPlan($_POST);
                }
                
                if(isset($_POST['save'])){
                    
                }
                
            }
            
            $data['case'] = Model_Case::find($case_id);
            $data['case']['id'] = $case_id;
            $data['header'] = Model_Case::getActionHeader($data['case']);
            
            $data['fgroups'] = Model_System_ObjectFields::findGroupsByIDs(array(25,26,27,28,29,30));
            $data['fields'] = Model_System_ObjectFields::findBySectionIDs(array(25,27));
            $data['options'] = Model_System_ObjectFields::findAllOptions(1);
            
            $data['total_fees'] = Model_Case::getTotalFees($case_id);
            $data['total_payments'] = Model_Payment::getTotalPayments($case_id);
            $data['scheduled_payments'] = Model_Payment::getTotalPayments($case_id, true);
            $data['last_pending_date'] = Model_Payment::getLastPendingDate($case_id);
            $data['payments'] = Model_Payment::findByCaseID($case_id);
            $this->response->body = View::factory('layout', array('l' => 'payment/manage', 'c' => $data));
        }
        
        function action_process($case_id){
            
            if(!empty($_POST)){
                
                try{
                    Model_Payment::process($case_id, $_POST);
                    notify::success('Payment of $'.$_POST['amount_received']. ' Received');
                    response::redirect('/payment/manage/'.$case_id);
                }catch(Exception $e){
                    notify::error($e);
                }
                
            }
            
            $data['case'] = Model_Case::find($case_id);
            $data['case']['id'] = $case_id;
            $data['header'] = Model_Case::getActionHeader($data['case']);
            
            $data['payment'] = Model_Payment::findNextPayment($case_id);
            if(!empty($data['payment'])){
                $data['payment']['amount_received'] = $data['payment']['amount'];
            }
            $this->response->body = View::factory('layout', array('l' => 'payment/process', 'c' => $data));
        }
        
        function action_update($case_id, $payment_id){
            
            if(!empty($_POST)){
                
                try{
                    Model_Payment::update($case_id, $payment_id, $_POST);
                    notify::success('Payment Updated');
                    response::redirect('/payment/manage/'.$case_id);
                }catch(Exception $e){
                    notify::error($e);
                }
                
            }
            
            $data['case'] = Model_Case::find($case_id);
            $data['case']['id'] = $case_id;
            $data['header'] = Model_Case::getActionHeader($data['case']);
            
            $data['payment'] = Model_Payment::find($case_id, $payment_id);
            $this->response->body = View::factory('layout', array('l' => 'payment/update', 'c' => $data));
        }
        
        function action_reset($case_id){
            Model_Payment::resetPaymentPlan($case_id);
            response::redirect('/payment/manage/'.$case_id);
        }
        
    }