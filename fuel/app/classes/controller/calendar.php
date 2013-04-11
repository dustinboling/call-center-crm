<?php

    class Controller_Calendar extends Controller_Base{
        
        function before(){
            parent::before();
            
            require PKGPATH.'Calendar/Calendar.php';
        }
        
        function action_index(){
            Response::redirect('calendar/day');
        }
                
        function action_day(){
            
            require PKGPATH.'Calendar/Day.php';
            
            if(empty($_GET['d'])){
                $date = new DateTime;
            }else{
                $date = new DateTime($_GET['d']);
            }
            
            $data['day'] = new Calendar\Day($date);
            
            $data['events'] = Model_Event::findByDate($date->format('Y-m-d'), $date->format('Y-m-d 23:59:59'));
            $data['day']->addItems($data['events']);
            
            $this->response->body = View::factory('layout', array('l' => 'calendar/day', 'c' => $data));
            
        }
                
        function action_week(){
            
            require PKGPATH.'Calendar/Week.php';
            
            if(empty($_GET['d'])){
                $date = new DateTime;
            }else{
                $date = new DateTime($_GET['d']);
            }
            
            $data['week'] = new Calendar\Week($date);
            $date = $data['week']->getWeekStartDate();
            $end = $data['week']->getWeekEndDate();
            $end->modify('+7 days');

            $data['events'] = Model_Event::findByDate($date->format('Y-m-d'), $end->format('Y-m-d'));
            $data['week']->addItems($data['events']);

            $this->response->body = View::factory('layout', array('l' => 'calendar/week', 'c' => $data));
            
        }
        
        function action_month(){
            
            require PKGPATH.'Calendar/Month.php';
            
            if(empty($_GET['d'])){
                $date = new DateTime;
            }else{
                $date = new DateTime($_GET['d']);
            }
            
            $end = new DateTime($date->format('Y-m-t'));
            
            $data['month'] = new Calendar\Month($date);
            
            $data['events'] = Model_Event::findByDate($date->format('Y-m-d'), $end->format('Y-m-d'));
            $data['month']->addItems($data['events']);
            
            $this->response->body = View::factory('layout', array('l' => 'calendar/month', 'c' => $data));
            
        }
        
    }
