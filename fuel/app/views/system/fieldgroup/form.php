
<h1><?php echo ucfirst(uri::segment(3));?> a <?php echo ucfirst(uri::segment(4));?></h1>

<div style="margin-bottom: 10px;">
    <a href="/system/field/listing/1" class="btn">Back to Fields</a>
</div>

<form action="" method="post" id="form">

<div class="control-group">
    <label class="control-label">Name</label>
    <div class="controls">
        <input type="text" name="name">
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