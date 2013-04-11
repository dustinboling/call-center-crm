<h3>Case Information</h3>

<div class="control-group">
    <label class="control-label">Included Parties</label>
    <div class="controls">
        <select name="parties">
            <option value="contact">Primary Contact Only</option>
            <option value="spouse">Spouse Only</option>
            <option value="both">Contact &amp; Spouse</option>
        </select>
    </div>
</div>    

<h3>Agent Assignments</h3>

<div class="control-group">
    <label class="control-label">Agent</label>
    <div class="controls">
        <select name="agent">
            <option value=""></option>
            <?php foreach($agents as $a):?>
            <option value="<?php echo $a['id'];?>"><?php echo $a['first_name'].' '.$a['last_name'];?></option>
            <?php endforeach;?>
        </select>
    </div>
</div>
