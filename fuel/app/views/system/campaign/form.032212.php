<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> a Campaign</h1>

<?php echo View::Factory('system/tabs')->render();?>
<form action="/system/campaign/<?php echo uri::segment(3);?>" method="post" id="form">
    
    <fieldset>
        
        <div class="clearfix">
            <label for="name">Name</label>
            <div class="input">
                <input type="text" name="name" class="span6">
            </div>
        </div>    
        
        <div class="form-actions">
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