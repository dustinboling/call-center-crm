<?php

    class Controller_Lead extends Controller_Base{
        
        function action_listing(){
            
            $data['leads'] = Model_Lead::findAll($this->offset, $this->limit);
            $data['pagination'] = array('limit' => $this->limit, 'total_items' => Model_Lead::countAll());
            $this->response->body = View::factory('layout', array('l' => 'lead/listing', 'c' => $data));
            
        }
        
    }