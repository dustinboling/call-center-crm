<h1 class="span16">Call Results: <?php (!empty($campaign)?print $campaign['name']:'');?> <?(!empty($_GET['start_date']) && !empty($_GET['end_date'])? print ' from '.urldecode($_GET['start_date']).' to '.urldecode($_GET['end_date']):'');?></h1>

<div class="span16">
        
    <ul class="tabs">
        <li><a href="/calltracking/campaign/listing">Campaign List</a></li>
        <li><a href="/calltracking/call/by_date/today">Today's Calls</a></li>
        <li class="active"><a href="#">Call Results</a></li>
    </ul>
    
    <?php echo $filter_bar;?>
    
    <div id="google_player"></div>

    <script type="text/javascript">
    $(document).ready(function(){
        $(".play_recording").click(function(e){
            $(".recording_active").addClass('play_recording').removeClass('recording_active');
            $(this).removeClass('play_recording').addClass('recording_active');
            $("#google_player").html('<embed src="/swf/google_player.swf" width="400" height="27" quality="best" type="application/x-shockwave-flash" flashvars="audioUrl='+$(this).attr('href')+'&autoPlay=true"></embed>') 
           e.preventDefault();
        });
        
        $(".recording_active").click(function(e){
            $(this).addClass('play_recording').removeClass('recording_active');
            $("#google_player").html('');
            e.preventDefault();
        });
    });
    </script>      
    
    <table class="zebra-striped">
        <thead>
            <tr>
                <th>Call Time</th>
                <th>Rep</th>
                <th>Caller</th>
                <th>Recipient</th>
                <th>Duration</th>
                <th>Disposition</th>
                <th>Notes</th>
                <th></th>
            </tr>    
        </thead>
        <tbody>
    <?php foreach($calls as $call):?>      
            <tr id="call_<?php echo $call['id'];?>">
                <td><?php echo \format::relative_date($call['start_time']);?></td>
                <td><?php (!empty($call['rep_name'])? print $call['rep_name']:print $call['receiving_extension']);?></td>
                <td width="150">
                    <?php echo \format::phone($call['caller_number']);?><br>
                    <small><?php if(!empty($call['caller_city'])){ echo $call['caller_city'].', '.$call['caller_state']; }?></small>
                </td>
                <td width="150">
                    <?php echo \format::phone($call['receiving_number']);?><br>
                    <small><?php echo $call['receiving_number_label'];?></small>
                </td>
                <td class="r" width="50"><?php echo \format::seconds_to_minutes($call['duration']);?></td>
                <td>
                    <ul class="unstyled disposition">
                        <li><a href="#" class="set_disposition"><?php (!empty($call['disposition']) ? print $call['disposition']: print 'not set');?></a>
                            <ul class="unstyled disposition_list">
                            </ul>
                        </li>
                    </ul>    
                </td>
                <td class="c" width="40">
                    <a href="/calltracking/note/call/<?php echo $call['id'];?>" class="view_notes"><img src="/img/icons/<?php ($call['notes'] ? print '':print 'empty_');?>note.png"></a>
                </td>
                <td width="20" class="c">
                    <?php if(!empty($call['recording_url'])):?>
                        <a href="<?php echo str_replace('api.twilio.com','recordings.pinnacletaxadvisors.com',$call['recording_url']);?>.mp3" class="play_recording"><img src="/img/icons/play.png"></a>
                    <?php endif;?>
                </td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php echo View::factory('pagination', $pagination)->render();?>
    
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var dispositions = <?php echo json_encode($dispositions);?>
        
        
        $(".set_disposition").click(function(e){
           $(".disposition_list").hide().html('');

           disposition_list = $(this).next('.disposition_list');
           call_id = $(this).parents('tr').attr('id').replace('call_','');

           $.each(dispositions, function(i, e){
               $(disposition_list).append('<li><a href="/calltracking/call/set_disposition/'+call_id+'/'+e.id+'" class="new_disposition">'+e.name+'</a></li>');
           });

           disposition_list.show();

           $(document.body).data('disposition_list', disposition_list);
           $(document.body).data('disposition_active', true);


           e.preventDefault();
        });
        
    });
</script>    
<script type="text/javascript" src="/js/calls.js"></script>    