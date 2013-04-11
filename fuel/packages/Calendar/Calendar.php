<?php
    
    namespace Calendar;

    abstract class Calendar{
        
        protected $date;
        protected $items = array();
        
        function __construct(\DateTime $date){
            $this->date = $date;
        }
        
        function getDate(){
            return $this->date;
        }
        
        function addItems($items){
            foreach($items as $i){
                $this->addItem($i);
            }
        }
        
        function addItem($item){
            $key = $this->getKey($item);
            if(empty($key)){
                $this->items[] = $item;
            }else{
                $this->items[$key] = $item;
            }
        }
        
        function getItemsRange(\DateTime $start, \DateTime $end){
            $matched = array();
            foreach($this->items as $k => $v){
                if($this->checkMatch($v, $start, $end)){
                    $matched[$k] = $v;
                }
            }
            return $matched;
        }
        
        function getKey($item){
            return null;
        }
     
        function checkMatch($item, \DateTime $start, \DateTime $end){
            $compare = new \DateTime($item['at']);
            if(($compare >= $start) && ($compare < $end)){ 
                return true;
            }
            return false;
        }
        
        function getItemLink(){
            return '/event/update/';
        }
    }