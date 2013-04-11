<?php

    class Controller_Calendar extends Controller_Base{
        
        function action_index(){
            Response::redirect('calendar/day');
        }
                
        function action_day(){
            
            require_once('../fuel/app/classes/utility/calendar.php');
            
            if (!isset($_GET['m']) && !isset($_GET['y'])) {
                $data['base_date'] = date("m/d/Y", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
            } else {
                $data['base_date'] = date("m/d/Y", strtotime($_GET['m'].'/01/'.$_GET['y'].' 00:00:00'));
            }
            
            $data['calendar'] = new Calendar( );
            $data['calendar']->setCalendarType('day');
            $data['calendar']->setBaseDate($data['base_date']);
            $data['calendar']->enableToday();
            $data['calendar']->setDayBaseUri('/calendar/day/');
            $data['calendar']->setMonthBaseUri('/calendar/month/');
            
            $this->response->body = View::factory('layout', array('l' => 'calendar/day', 'c' => $data));
            
        }
                
        function action_week(){
            
            require_once('../fuel/app/classes/utility/calendar.php');
            
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
            
            $data['calendar'] = new Calendar( );
            $data['calendar']->setCalendarType('week');
            $data['calendar']->setBaseDate($data['base_date']);
            $data['calendar']->enableToday();
            $data['calendar']->setDayBaseUri('/calendar/day/');
            $data['calendar']->setMonthBaseUri('/calendar/month/');
            
            $this->response->body = View::factory('layout', array('l' => 'calendar/week', 'c' => $data));
            
        }
        
        function action_month(){
            
            require_once('../fuel/app/classes/utility/calendar.php');
            
            if (!isset($_GET['m']) && !isset($_GET['y'])) {
                $data['base_date'] = date("m/d/Y", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
            } else {
                $data['base_date'] = date("m/d/Y", strtotime($_GET['m'].'/01/'.$_GET['y'].' 00:00:00'));
            }
            
            $data['calendar'] = new Calendar( );
            $data['calendar']->setCalendarType('month');
            $data['calendar']->setBaseDate($data['base_date']);
            $data['calendar']->enableToday();
            $data['calendar']->setDayBaseUri('/calendar/day/');
            $data['calendar']->setWeekBaseUri('/calendar/week/');
            
            $this->response->body = View::factory('layout', array('l' => 'calendar/month', 'c' => $data));
            
        }
        
    }