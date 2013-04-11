<?php
    
    namespace Calendar;
    
    class Month extends Calendar{
        
        protected $first_date;
        protected $first_day;
        protected $day_of_week;
        
        function __construct($date){
            $this->date = new \DateTime($date->format('Y-m-d 00:00:00'));
        }
        
        function __toString(){
           
            $out = '<table class="table table-bordered"><thead><tr>';
            
            foreach($this->getDayTitles() as $d){
                $out .= '<th>'.$d.'</th>';
            }
           
            $out .= '</tr></thead><tr>';
            
            $dts = $this->getDateTimes();
            
            foreach($dts as $d){
                $first = $d;
                break;
            }
            
            $out .= $this->padBeginning($first->format('w'));
            
            foreach($dts as $d){
                if($d->format('w') == 0){ $out .= '<tr>'; }
                $e = clone $d;
                $out .= $this->getContainer($e);
                if($d->format('w') == 6){ $out .= '</tr>'; }
            }
            
            return $out. '</table>';
        }
        
        function getDateTimes(){
            $start = new \DateTime($this->date->format('Y-m-01 H:i:s'));
            $dts = new \DatePeriod($start, new \DateInterval('P1D'), $start->format('t')-1);    
            return $dts;
        }
        
        function getOffset(){
            return '+1 day';
        }
        
        function getContainer(\DateTime $date = null){
            
            if(empty($date)){
                return '<td class="day empty">&nbsp;</td>';
            }
            
            $start = clone $date;
            $start->modify('midnight');
            
            $end = clone $start;
            $end->modify('+1 day');

            $m = $this->getItemsRange($start, $end);

            return '<td class="day active"><a href="'.$this->getLink($date).'">'.$date->format('j').'</a>'.$this->outputItems($m).'</td>';
            
        }
        
        function outputItems($items){
            
            if(!count($items)){
                return;
            }
            
            $out = '<ul class="unstyled">';
            
            foreach($items as $i){
                if(!empty($i['case_id'])){
                    $out .= '<li><a href="/case/update/'.$i['case_id'].'" class="label label-info">'.$i['case_id'].'</a> <a href="'.$this->getItemLink().$i['id'].'">'.$i['title'].'</a></li>';
                }else{
                    $out .= '<li><a href="'.$this->getItemLink().$i['id'].'">'.$i['title'].'</a></li>';
                }
                
            }
            
            $out .= '</ul>';
            
            return $out;
        }
        
        function padBeginning($items){
            $out = '';
            while($items > 0){
                $out .= $this->getContainer();
                $items--;
            }
            return $out;
        }
        
        function getDayTitles(){
            return array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        }
        
        function getLink(\DateTime $date){
            return '/calendar/day/?d='.$date->format('Y-m-d');
        }
        
    }