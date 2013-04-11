<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> a Milestone</h1>

<?php echo View::Factory('system/tabs')->render();?>

<form action="/system/milestone/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>/<?php echo uri::segment(5);?>" method="post" id="form">
    <fieldset>
        
        <div class="control-group">
            <label for="name">Name</label>
            <div class="controls">
                <input type="text" name="name" class="span8">
            </div>
        </div> 
        
        <div class="form-actions">
            <button class="btn btn-primary">Save</button>
        </div>
        
    </fieldset>    
    
</form>    

<script type="text/javascript">
$(document).ready(function(){
    
   $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($row)?json_encode($row):'')); ?>); 
    
});
</script>