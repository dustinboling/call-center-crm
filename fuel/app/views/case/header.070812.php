<div class="row-fluid">
<div class="span12">
<form action="/case/update/<?php echo uri::segment(3);?>" method="post" class="form" id="case_quickview">
<table class="table table-bordered" style="width: 100%;">
    <tr class="case_bar">
        <td class="alert alert-info id"><?php echo $case['id'];?></td>
        <td class="ttl">Campaign</td>
        <td class="field">
            <select name="campaign_id">
                <option value=""></option>
                <?php foreach($campaigns as $c):?>
                <option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td class="ttl">Sales Rep</td>
        <td class="field">
            <select name="sales_rep_id">
                <option value=""> </option>
                <?php foreach($users as $u):?>
                <option value="<?php echo $u['id'];?>"><?php echo $u['first_name'] . ' ' . $u['last_name'];?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td class="ttl">Timezone</td>
        <td class="field">
            <select name="timezone">
                <option value="Pacific">Pacific</option>
                <option value="Mountain">Mountain</option>
                <option value="Central">Central</option>
                <option value="Eastern">Eastern</option>
            </select>
        </td>
        <td class="ttl"><button class="btn btn-success" type="submit">Save This Row</button></td>
    </tr>
</table>
</form>
</div>
    
    <div class="row-fluid">
        
        <div class="span4">
            <h2>Status &amp; Actions</h2>
            <table class="table table-striped table-bordered">
                <tr>
                    <td width="125">Current Status</td>
                    <td id="status_container">

                        <?php echo $case['status'];?> 
						
						
 <!--                       <small><a href="#" id="change_status">change</a></small> -->
                    
					
					</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <form action="/case/run_action/<?php echo $case['id'];?>" method="post" style="margin:0">
                        <select name="action_id" id="action_id" style="margin-bottom: 0;" class="input-xlarge">
                            <?php foreach($actions as $a):?>
                            <option value="<?php echo $a['id'];?>" data-task="<?php echo $a['set_task'];?>"><?php echo $a['name'];?></option>
                            <?php endforeach;?>
                        </select>
                        <button class="btn btn-primary" type="submit" id="run_action">Run</button><br>
                        <textarea name="note" placeholder="Action Notes" style="margin-top: 10px; width: 95%;"></textarea>
                        <table class="table table-striped table-bordered" id="set_appointment">
                            <thead>
                                <tr>
                                    <th colspan="2">Set an Appointment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Title</td>
                                    <td><input type="text" name="event[title]" class="input-xlarge"></td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td><textarea name="event[description]" style="margin-top: 10px; width: 95%;"></textarea></td>
                                </tr>
                                <tr>
                                    <td>When</td>
                                    <td>
                                        <input type="text" name="event[date]" class="datepicker input-small" placeholder="Date">
                                        <input type="text" name="event[time]" class="input-small" placeholder="12:00pm">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Reminder</td>
                                    <td>
                                        <select name="event[alert_offset]" class="input-medium">
                                            <option value="0">At time of event</option>
                                            <option value="-5 minutes">5 minutes before</option>
                                            <option value="-15 minutes">15 minutes before</option>
                                            <option value="-30 minutes">30 minutes before</option>
                                            <option value="-1 hour">1 hour before</option>
                                            <option value="-2 hours">2 hours before</option>
                                            <option value="-1 day">1 day before</option>
                                            <option value="-2 days">2 days before</option>
                                        </select> 
                                        <input type="checkbox" name="event[alert_email]" value="1"> Email 
                                        <input type="checkbox" name="event[alert_popup]" value="1"> Popup
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><button class="btn btn-primary" name="with_event" type="submit">Run Action and Set Appointment</button>
                                </tr>
                            </tbody>
                        </table>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="span8" style="height: 210px; overflow:scroll;">
            
            <h2>Recent Activity</h2>
            <table class="table table-striped table-bordered">
                <?php if(count($activity)):?>
                <?php $l = 1;?>
                <?php foreach($activity as $a):?>
                <tr>
                    <td width="125">
                        <small><?php (empty($a['name'])? print 'System Action':print $a['name']);?></small><br>
                        <span class="label"><?php echo format::relative_date($a['ts']);?></span>
                    </td>
                    <td><?php echo $a['message'];?><?php if(!empty($a['note'])):?><br><small><?php echo $a['note'];?></small><?php endif;?></td>
                </tr>
                <?php $l++; if($l == 11){ break; } ?>
                <?php endforeach;?>
                <?php else:?>
                <tr>
                    <td>No Recent Activity</td>
                </tr>
                <?php endif;?>
            </table>
            
        </div>
        
    </div>    
    
<?php foreach(array('federal_owed','federal_not_filed','state_owed','state_not_filed') as $field){ if(isset($case[$field])){ unset($case[$field]); } } ?>
    
<script type="text/javascript">

$(function(){
                
    $("#case_quickview").populate(<?php echo (isset($case)?json_encode($case):''); ?>);
    
    $("#change_status").click(function(e){
            
        $.get('/case/status_json', function(data){

            var form = '<form action="/case/change_status/<?php echo uri::segment(3);?>" method="post" style="margin: 0; padding: 0;">';
            form += '<select name="status_id">';

            $.each(data, function(i,e){
               form += '<option value="'+e.id+'">'+e.name+'</option>';
            });

            form += '</select>';
            form += ' <button class="btn btn-primary" style="vertical-align:top;">Save</button>';
            form += '</form>';

            $("#status_container").html(form);

        }, 'json');

        e.preventDefault;

    });
    
    $("#action_id").change(function(e){
        if($("#action_id option:selected").attr('data-task') == 1){
            $("#set_appointment").show();
            $("#run_action").hide();
        }else{
            $("#set_appointment").hide();
            $("#run_action").show();
        }
    });
    
    $(".datepicker").datepicker();
    
});

</script>