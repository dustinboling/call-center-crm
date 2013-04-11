<?php
    
    namespace Calendar;
    
    class Week extends Calendar{
        
        protected $week_start = 0;
        
        function __construct(\DateTime $date){
            $this->date = new \DateTime($date->format('Y-m-d 05:00:00'));
        }
        
        function __toString(){
            $out = '<table class="table table-striped">';
            
            $out .= '<thead><tr>';
            $out .= '<td></td>';
            
            $date = $this->getWeekStartDate();
            for($i=1;$i<=7;$i++){
                $out .= '<th>'.$date->format('l n/j').'</th>';
                $date->modify('+1 day');
            }
            
            $out .= '</tr></thead>';
            
            foreach($this->getDateTimes() as $i){
                $start = clone $i;
                $end = clone $i;
                $end->modify('+1 hour');
                
                $out .= '<tr>';
                $out .= '<td>'.$start->format('ga').'</td>';
                
                $day_start = clone $start;
                $day_end = clone $end;
                
                for($i=1;$i<=7;$i++){
                    
                    $out .= '<td class="week-day">'.$this->outputItems($this->getItemsRange($day_start, $day_end)).'</td>';
                    $day_start->modify('+1 day');
                    $day_end->modify('+1 day');
                }                
                
                $out .= '</tr>';
                
            }
            
            $out .= '</table>';

            return $out;
        }
        
        function outputLabel(\DateTime $date){
            return '<td width="200"><a href=/calendar/day/?d='.$date->format('Y-m-d').'>'.$date->format('l m/d/y').'</a></td>';
        }
    
        function outputItems($items){
            foreach($items as $i){
                if(!empty($i['case_id'])){
                    return '<div><a href="/case/update/'.$i['case_id'].'" class="label label-info">'.$i['case_id'].'</a> <a href="'.$this->getItemLink().$i['id'].'">'.$i['title'].'</a></div>';
                }else{
                    return '<div><a href="'.$this->getItemLink().$i['id'].'">'.$i['title'].'</a></div>';
                }
            }
        }
        
        function getDateTimes(){
            $current = new \DateTime($this->date->format('Y-m-d H:i:s'));
            $dts = new \DatePeriod($this->getWeekStartDate($current), new \DateInterval('PT1H'), 18);
            return $dts;
            
        }
        
        function getWeekStartDate(\DateTime $date = null){
            
            if(empty($date)){
                $date = clone $this->date;
            }
            
            $offset = $this->week_start - $date->format('w');
            $date->modify($offset . ' days');
            return $date;
        }
        
        function getWeekEndDate(){
            $last = '';
            foreach($this->getDateTimes() as $d){
                $last = $d;
            }
            
            return $last;
        }
        
    }