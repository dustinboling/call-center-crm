<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> a User</h1>

<?php echo View::Factory('system/tabs')->render();?>
<form action="/system/user/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>" method="post" id="form">
    
    <fieldset>
        
        <div class="control-group">
            <label class="control-label" for="first_name">First Name</label>
            <div class="controls">
                <input type="text" name="first_name">
            </div>
        </div>    
        
        <div class="control-group">
            <label class="control-label" for="last_name">Last Name</label>
            <div class="controls">
                <input type="text" name="last_name">
            </div>
        </div>    
        
        <div class="control-group">
            <label class="control-label" for="type">Type</label>
            <div class="controls">
                <select name="type">
                    <option value="User">User</option>
                    <option value="Power User">Power User</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
        </div> 
        
        <div class="control-group">
            <label class="control-label" for="department">Department</label>
            <div class="controls">
                <select name="department">
                    <option value="">Not Set</option>
                    <option value="Sales">Sales</option>
                    <option value="Agent"> Transfer Agent</option>
                </select>
            </div>
        </div> 
        
        <div class="control-group">
            <label class="control-label" for="email">Email</label>
            <div class="controls">
                <input type="text" name="email">
            </div>
        </div>    
        
        <div class="control-group">
            <label class="control-label" for="passwd">Password</label>
            <div class="controls">
                <input type="password" name="passwd">
            </div>
        </div>       
        
        <div class="form-actions">
            <button class="btn btn-primary">Save</button>
        </div>
        
    </fieldset>    
</form>        

</div>

<?php if(isset($row['passwd'])){ unset($row['passwd']); } ?>
<script type="text/javascript">
$(document).ready(function(){
    
   $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($row)?json_encode($row):'')); ?>); 

});
</script>