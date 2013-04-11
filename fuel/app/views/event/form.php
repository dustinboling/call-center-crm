<h1><?php echo ucwords(uri::segment(2));?> an Appointment</h1>

<a href="javascript:history.go(-1)" class="btn">Back</a>

<form action="/event/<?php echo ucwords(uri::segment(2));?>/<?php echo uri::segment(3);?>" method="post" id="form">
    
    <fieldset>
        
        <div class="control-group">
            <label for="control-label">Case ID</label>
            <div class="controls">
                <input type="text" name="case_id">
            </div>
        </div> 
        
        <div class="control-group">
            <label for="control-label">Assign To</label>
            <div class="controls">
                <select name="user_id">
                    <option value="<?php echo $_SESSION['user']['id'];?>">Me</option>
                    <?php foreach($users as $u):?>
                    <option value="<?php echo $u['id'];?>"><?php echo $u['first_name'] . ' ' . $u['last_name'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div> 
        
        <div class="control-group">
            <label for="control-label">Appointment At</label>
            <div class="controls">
                <input type="text" name="date" class="datepicker input-small">
                <input type="text" name="time" class="input-small" placeholder="12:00pm">
            </div>
        </div> 
        
        <div class="control-group">
            <label for="control-label">Reminder</label>
            <div class="controls">
                <?php if(uri::segment(2) == 'add'):?>
                <select name="alert_offset" class="input-medium">
                    <option value="0">At time of event</option>
                    <option value="-5 minutes">5 minutes before</option>
                    <option value="-15 minutes">15 minutes before</option>
                    <option value="-30 minutes">30 minutes before</option>
                    <option value="-1 hour">1 hour before</option>
                    <option value="-2 hours">2 hours before</option>
                    <option value="-1 day">1 day before</option>
                    <option value="-2 days">2 days before</option>
                </select> 
                <?php endif;?>
                <input type="checkbox" name="alert_email" value="1"> Email 
                <input type="checkbox" name="alert_popup" value="1"> Popup
            </div>
        </div> 
        
        <div class="control-group">
            <label for="control-label">Title</label>
            <div class="controls">
                <input type="text" name="title" class="input-xxlarge">
            </div>
        </div> 
        
        <div class="control-group">
            <label for="control-label">Description</label>
            <div class="controls">
                <textarea name="description" class="input-xxlarge"></textarea>
            </div>
        </div> 
        
        <div class="form-actions">
            <button class="btn btn-primary">Save</button>
        </div>   
        
    </fieldset>
    
</form>   

<?php 
    if(isset($event)){
        $event['date'] = date('m/d/y', strtotime($event['at']));
        $event['time'] = date('g:ia', strtotime($event['at']));
    }
?>
        
<script type="text/javascript">
$(document).ready(function(){
    $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($event)?json_encode($event):'')); ?>);
});

</script>       