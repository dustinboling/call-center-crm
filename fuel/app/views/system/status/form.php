<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> a Status</h1>

<?php echo View::Factory('system/status/tabs')->render();?>

<form action="/system/status/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>/<?php echo uri::segment(5);?>" method="post" id="form">
    <input type="hidden" name="group_id" value="<?php echo uri::segment(4);?>">
    <fieldset>
        
        <div class="control-group">
            <label for="name">Name</label>
            <div class="controls">
                <input type="text" name="name" class="span8">
            </div>
        </div>    
        
        <div class="control-group">
            <label for="level">Level</label>
            <div class="controls">
                <select name="level" class="small">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>	  
                </select>
            </div>
        </div> 
        
        <div class="control-group">
            <label for="milestone_id">Milestone</label>
            <div class="controls">
                <select name="milestone_id">
                    <option value="0"></option>
                    <?php foreach($milestones as $m):?>
                    <option value="<?php echo $m['id'];?>"><?php echo $m['name'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div> 
        
        <div class="control-group">
            <label for="actions">Allow Actions</label>
            <div class="controls">
                <select name="action_ids[]" multiple size="10" class="span6">
                    <?php foreach($actions as $action):?>
                    <option value="<?php echo $action['id'];?>"><?php echo $action['name'];?></option>
                    <?php endforeach;?>
                </select>
                <span class="help-block">Hold CTRL + click to select multiple</span>
            </div>
        </div>
        
        <div class="control-group">
            <label for="actions">Expiration</label>
            <div class="controls">
                In
                <input type="text" name="expiry_days" class="input-mini"> Day(s)
                run
                <select name="expiry_action_id" class="small">
                    <option value="0"></option>
                    <?php foreach($actions as $a):?>
                        <option value="<?php echo $a['id'];?>"><?php echo $a['name'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        
        <div class="actions">
            <button class="btn primary">Save</button>
        </div>
        
    </fieldset>    
</form>

</div>

<script type="text/javascript">
$(document).ready(function(){
    
   $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($row)?json_encode($row):'')); ?>); 
    
});
</script>