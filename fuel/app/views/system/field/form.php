<?php $container_id = uri::segment(5);?>

<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> a <?php echo $object['name'];?> Field</h1>

<?php echo View::Factory('system/tabs')->render();?>


<form action="/system/field/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>/<? (uri::segment(5) != ''? print '/'.uri::segment(5):'');?>" method="post" id="form">

    <fieldset>
        
        <div class="clearfix">
            <label for="name">Name</label>
            <div class="input">
                <input type="text" name="name">
            </div>
        </div>  
        
<?php if(empty($container_id)):?>    
        
        <div class="clearfix">
            <label for="field_type_id">Type</label>
            <div class="input">
                <select name="field_type_id">
                    <?php foreach($field_types as $t):?>
                    <?php if($t['structure']):?>
                    <option value="<?php echo $t['id'];?>"><?php echo $t['name'];?></option>
                    <?php endif;?>
                    <?php endforeach;?>
                </select>
            </div>
        </div> 
        
<?php else: ?>        
        <div class="clearfix">
            <label for="field_type_id">Type</label>
            <div class="input">
                <select name="field_type_id">
                    <?php foreach($field_types as $t):?>
                    <?php if(!$t['structure']):?>
                    <option value="<?php echo $t['id'];?>"><?php echo $t['name'];?></option>
                    <?php endif;?>
                    <?php endforeach;?>
                </select>
            </div>
        </div>  
<?php /*       
        <div class="clearfix">
            <label for="validation">Validation</label>
            <div class="input">
                <select name="validation_id">
                    <option value="0">None</option>
                    <?php foreach($field_validation as $v):?>
                    <option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>  
        
        <div class="clearfix">
            <label for="required">Required</label>
            <div class="input">
                <select name="required">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
        </div>  
        
        <div class="clearfix">
            <label for="editable">Editable</label>
            <div class="input">
                <select name="editable">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>  
 */?>
<?php endif;?>        
        <div class="actions">
            <button class="btn primary">Save</button>
        </div>
        
    </fieldset>    
    
</form>

<script type="text/javascript">
    $(document).ready(function(){
        $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($row)?json_encode($row):'')); ?>);
    });
</script>    