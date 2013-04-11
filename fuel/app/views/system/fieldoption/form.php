
<h1><?php echo ucfirst(uri::segment(3));?> an Option for <?php echo $field['name'];?></h1>

<div style="margin-bottom: 10px;">
    <a href="/system/fieldoption/listing/<?php echo uri::segment(4);?>" class="btn">Back to Options</a>
</div>

<form action="" method="post" id="form">

<div class="control-group">
    <label class="control-label">Value</label>
    <div class="controls">
        <input type="text" name="value">
    </div>    
</div>

<div class="form-actions">
    <input type="submit" class="btn btn-primary" value="Save">
</div>
    
</form> 

<script type="text/javascript">
    $(document).ready(function(){
        $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($row)?json_encode($row):'')); ?>);
    });
</script>   