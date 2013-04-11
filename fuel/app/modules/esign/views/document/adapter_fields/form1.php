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

<h2>Agent Assignments</h2>
<table class="table table-striped table-bordered">
    <tr>
        <td width="125">2848 Agent 1</td>
        <td>
            <select name="f2848_agent_1">
                <option value=""></option>
                <?php foreach($agents as $a):?>
                <option value="<?php echo $a['id'];?>"><?php echo $a['first_name'].' '.$a['last_name'];?></option>
                <?php endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td width="125">2848 Agent 2</td>
        <td>
            <select name="f2848_agent_2">
                <option value=""></option>
                <?php foreach($agents as $a):?>
                <option value="<?php echo $a['id'];?>"><?php echo $a['first_name'].' '.$a['last_name'];?></option>
                <?php endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td width="125">2848 Agent 3</td>
        <td>
            <select name="f2848_agent_3">
                <option value=""></option>
                <?php foreach($agents as $a):?>
                <option value="<?php echo $a['id'];?>"><?php echo $a['first_name'].' '.$a['last_name'];?></option>
                <?php endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td width="125">8821 Agent</td>
        <td>
            <select name="f8821_agent">
                <option value=""></option>
                <?php foreach($agents as $a):?>
                <option value="<?php echo $a['id'];?>"><?php echo $a['first_name'].' '.$a['last_name'];?></option>
                <?php endforeach;?>
            </select>
        </td>
    </tr>
</table> 