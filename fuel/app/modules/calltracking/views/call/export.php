<?php
    
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename=CallExport'.date('mdy_his').'.csv');
    
    $data[] = array(
                    'Call Time',
                    'Caller Number',
                    'Caller State',
                    'Receiving Number',
                    'Receiving Label',
                    'Sales Rep',
                    'Duration',
                    'Disposition',
                    'Notes',
                    'Recording'
                );
    
    foreach($calls as $call){
        if($call['duration'] > 0){
            $data[] = array(
                            date('m/d/Y g:ia', strtotime($call['start_time'])),
                            format::phone($call['caller_number']),
                            $call['caller_state'],
                            format::phone($call['receiving_number']),
                            $call['receiving_number_label'],
                            $call['rep_name'],
                            format::seconds_to_minutes($call['duration']),
                            $call['disposition'],
                            (isset($notes[$call['id']])?implode(' | ',$notes[$call['id']]):''),
                            str_replace('api.twilio.com','recordings.pinnacletaxadvisors.com',$call['recording_url']).'.mp3'
                            );   
        }
        
    }
    
    foreach($data as $row){    
        $outstream = fopen("php://temp", 'w+');
        fputcsv($outstream, $row, ',', '"');
        rewind($outstream);
        $csv = fgets($outstream);
        fclose($outstream);
        print $csv;
    }
    
    