<?php

    class Controller_Sync extends Controller{
        
        function action_extensions(){
            
            $since = date('Y-m-d H:i:s', strtotime('-18 hours'));
            $since = '2011-09-01';
            $result = DB::select('id', 'start_time', 'caller_number', 'duration', 'receiving_extension')
                    ->from('ct_calls')
                    ->where('receiving_extension', '=', null)
                    ->where('start_time', '>', $since)
                    ->execute();

            $numbers = array();
            foreach($result->as_array() as $row){
                $number = substr($row['caller_number'], 2);
                $numbers[$number] = $number;
            }
            
            if(empty($numbers)){
                exit;
            }
            
            $number_list = "'".implode("','", $numbers)."'";
            
            $db = new PDO('mysql:dbname=asteriskcdrdb;host=64.58.156.254', 'developer', 'Developer@1234');
            
            $sql = "SELECT calldate, dst, duration, uniqueid FROM cdr WHERE calldate >= '$since' AND src IN ($number_list) AND disposition = 'ANSWERED' AND dcontext = 'from-internal'";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            
            $twi_calls = $result->as_array();
            
            while($ast_call = $stmt->fetch(PDO::FETCH_ASSOC)){
                foreach($twi_calls as $k => $v){
                    $ast_ts = strtotime($ast_call['calldate']) + $ast_call['duration'];
                    $twi_ts = strtotime($v['start_time']);
                    
                    if(($ast_ts-5) < $twi_ts && $twi_ts < ($ast_ts+5)){
                        
                        DB::update('ct_calls')->set(array('receiving_extension' => $ast_call['dst']))->where('id', '=', $v['id'])->execute();
                        
                        unset($twi_calls[$k]);
                        break;
                    }
                }
            } 
            
        }
        
    }