<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> Communication</h1>

<?php echo View::Factory('system/tabs')->render();?>

<form action="/system/communication/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>" method="post" id="form">
    
    <fieldset>
        
        <div class="clearfix">
            <label for="name">Name</label>
            <div class="input">
                <input type="text" name="name" class="span8">
            </div>
        </div>   
        
        <div class="clearfix">
            <label for="template_email_id">Email</label>
            <div class="input">
                <select name="template_email_id">
                <option value="0">None</option>
                <?php foreach($emails as $e):?>
                    <option value="<?php echo $e['id'];?>"><?php echo $e['name'];?></option>
                <?php endforeach;?>    
                </select>    
            </div>
        </div> 
        
        <div class="clearfix">
            <label for="template_call_id">Call</label>
            <div class="input">
                <select name="template_call_id">
                <option value="0">None</option>
                <?php foreach($calls as $c):?>
                    <option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
                <?php endforeach;?>    
                </select>    
            </div>
        </div> 
        
        <div class="clearfix">
            <label for="template_sms_id">Text</label>
            <div class="input">
                <select name="template_sms_id">
                <option value="0">None</option>
                <?php foreach($sms_messages as $s):?>
                    <option value="<?php echo $s['id'];?>"><?php echo $s['name'];?></option>
                <?php endforeach;?>    
                </select>    
            </div>
        </div> 
        
        <div class="actions">
            <button class="btn primary">Save</button>
        </div>
        
    </fieldset> 
    
<script type="text/javascript">
$(document).ready(function(){
   $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($row)?json_encode($row):'')); ?>); 
});
</script>    