<?php

    class Controller_SFPayment extends Controller_Base{
        
        function action_case($case_id){
            
            $data['case'] = Model_Case::find($case_id);
            $data['case']['id'] = $case_id;
            $data['header'] = Model_Case::getActionHeader($data['case']);
            
            $data['payments'] = Model_SFPayment::findByCase($case_id);
            
            $this->response->body = View::factory('layout', array('l' => 'sfpayment/case', 'c' => $data));
            
        }
        
    }
