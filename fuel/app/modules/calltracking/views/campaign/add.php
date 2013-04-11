<div class="span16"><h1>Add Campaign</h1></div>

<form action="/calltracking/campaign/add/" method="post" id="form">

<div class="span8">
        
        <fieldset>
            
            <div class="clearfix">
                <label for="name">Name</label>
                <div class="input">
                    <input type="text" name="name">
                </div>
            </div>
            
            <div class="clearfix">
                <label for="subaccount">Sub Account</label>
                <div class="input">
                    <select name="subaccount_id">
                        <option value="0">None</option>
                        <?php foreach($subaccounts as $s):?>
                        <option value="<?php echo $s['id'];?>"><?php echo $s['company'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            
            <div class="clearfix">
                <label for="incoming_number">Incoming Number</label>
                <div class="input">
                    <select name="incoming_number">
                        <?php foreach($purchased_numbers as $n):?>
                        <option value="<?php echo $n['id'];?>" <?php (uri::segment(4) == $n['id']? print 'selected="selected"':'');?>><?php (!empty($n['label'])?print $n['label'].': ':'');?><?php echo format::phone($n['number']);?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            
            <div class="clearfix">
                <label for="forwarding_number">Forwarding Number</label>
                <div class="input">
                    <select name="forwarding_number">
                        <?php foreach($internal_numbers as $n):?>
                        <option value="<?php echo $n['id'];?>"><?php echo $n['label'];?>: <?php echo format::phone($n['number']);?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            
            <div class="actions">
                <button class="btn primary" type="submit">Save</button>
            </div>
            
        </fieldset>    
            
</div>
    
<div class="span8">

    <fieldset>
        <legend>After Hours Forwarding</legend>
        <div class="clearfix">
            <label for="after_hours_forwarding">Active</label>
            <div class="input">
                <select name="after_hours_forwarding" id="after_hours_forwarding" class="small">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
        </div>
        
        <div id="after_hours_forwarding_container">
        
            <div class="clearfix">
                <label for="after_hours_number">Forward To</label>
                <div class="input">
                    <select name="after_hours_number">
                        <?php foreach($internal_numbers as $n):?>
                        <option value="<?php echo $n['id'];?>"><?php echo $n['label'];?>: <?php echo format::phone($n['number']);?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="clearfix">
                <label for="">Start Forwarding</label>
                <div class="input">
                    <div class="inline-inputs">
                        <select class="mini" name="ahf_start_hour">
                            <?php echo FormSelect::range_leading(1,12,2);?>
                        </select>
                        <select class="mini" name="ahf_start_minute">
                            <?php echo FormSelect::range_leading(0,59,2);?>
                        </select>
                        <select class="mini" name="ahf_start_meridiem">
                            <option value="am">am</option>
                            <option value="pm">pm</option>
                        </select>
                    </div>
                </div>    
            </div>

            <div class="clearfix">
                <label for="">End Forwarding</label>
                <div class="input">
                    <div class="inline-inputs">
                        <select class="mini" name="ahf_end_hour">
                            <?php echo FormSelect::range_leading(1,12,2);?>
                        </select>
                        <select class="mini" name="ahf_end_minute">
                            <?php echo FormSelect::range_leading(0,59,2);?>
                        </select>
                        <select class="mini" name="ahf_end_meridiem">
                            <option value="am">am</option>
                            <option value="pm">pm</option>
                        </select>
                    </div>
                </div>    
            </div>
            
        </div>    
        
    </fieldset>

</div>
    
</form>    

<script type="text/javascript">
    $(document).ready(function(){
       $("#form").populate(<?php echo json_encode($campaign);?>); 
       
       $("#after_hours_forwarding").change(function(e){
          manage_after_hours_state($(this).val());
       });
       
       manage_after_hours_state($("#after_hours_forwarding").val());
    });
    
    function manage_after_hours_state(status){
        if(status == 1){
            $("#after_hours_forwarding_container").show();
        }else{
            $("#after_hours_forwarding_container").hide();
        }
    }
</script>