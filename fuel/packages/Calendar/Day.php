<?php
    
    namespace Calendar;

    class Day extends Calendar{
        
        function __construct(\DateTime $date){
            $this->date = new \DateTime($date->format('Y-m-d 05:00:00'));
        }
        
        function __toString(){
            
            $out = '<table class="table table-striped">';
            foreach($this->getDateTimes() as $i){
                $end = clone $i;
                $end->modify('+1 hour');
                
                $out .= '<tr>';
                $out .= '<td width="200">';
                $out .= $i->format('ga');
                $out .= '</td>';
                $out .= '<td>';
                $out .= $this->outputItems($this->getItemsRange($i, $end));
                $out .= '</td>';
                $out .= '</tr>';
            }
            return $out. '</table>';
            
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
            $current = new \DateTime($this->date->format('Y-m-d'));
            $dts = new \DatePeriod($this->date, new \DateInterval('PT1H'), 18);
            return $dts;
        }
        
    }