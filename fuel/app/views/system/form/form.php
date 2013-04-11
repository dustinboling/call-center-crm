<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> a Form</h1>

<?php echo View::Factory('system/tabs')->render();?>
<div class="r"><a id="tf_dialog" class="btn primary r">Show Available Fields</a></div>
<form action="/system/form/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>" method="post" id="form" enctype="multipart/form-data">
    
    <fieldset>
        
        <div class="clearfix">
            <label for="name">Name</label>
            <div class="input">
                <input type="text" name="name" class="span8">
            </div>
        </div>   
        
        <div class="clearfix">
            <label for="file">File</label>
            <div class="input">
                <input type="file" name="file">
            </div>
        </div> 
        
        <div class="clearfix">
            <label for="data_template">Data Template</label>
            <div class="input">
                <textarea name="data_template" id="template_field_target" class="span8" style="height: 400px;"><?php if(isset($row['data_template'])){ echo $row['data_template']; } ?></textarea>    
            </div>
        </div> 
        
        <div class="clearfix">
            <label for="echosign">Connect to Echosign</label>
            <div class="input">
                <select name="esign">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>    
            </div>
        </div>
        
        <div class="actions">
            <button class="btn primary">Save</button>
        </div>
        
    </fieldset> 
    
    <?php echo View::factory('system/template_fields', array('fields' => $fields));?>    
    
<?php if(isset($row['data_template'])){ unset($row['data_template']); } ?>    
<script type="text/javascript">
$(document).ready(function(){
   $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($row)?json_encode($row):'')); ?>);
});
</script>    