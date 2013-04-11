<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?>  an Email Template</h1>

<?php echo View::Factory('system/tabs')->render();?>
<div class="r"><a id="tf_dialog" class="btn primary r">Show Available Fields</a></div>
<form action="/system/email/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>" method="post" id="form">
    
    <fieldset>
        
        <div class="clearfix">
            <label for="name">Name</label>
            <div class="input">
                <input type="text" name="name" class="span8">
            </div>
        </div>    
        
        <div class="clearfix">
            <label for="from">From Email</label>
            <div class="input">
                <input type="text" name="from" class="span6">
            </div>
        </div>    
        
        <div class="clearfix">
            <label for="to">To Email</label>
            <div class="input">
                <input type="text" name="to" class="span6">
            </div>
        </div>    
        
        <div class="clearfix">
            <label for="cc">CC Email(s)</label>
            <div class="input">
                <input type="text" name="cc" class="span6">
                <span class="help-inline">Separate with commas</span>
            </div>
        </div>    
        
        <div class="clearfix">
            <label for="bcc">BCC Email(s)</label>
            <div class="input">
                <input type="text" name="bcc" class="span6">
                <span class="help-inline">Separate with commas</span>
            </div>
        </div>    
        
        <div class="clearfix">
            <label for="subject">Subject</label>
            <div class="input">
                <input type="text" name="subject" class="span8">
            </div>
        </div>    
        
        <div class="clearfix">
            <label for="subject">Message</label>
            <div class="input">
                <textarea name="message" class="span8"></textarea>
            </div>
        </div>    
        
        <div class="actions">
            <button class="btn primary">Save</button>
        </div>    
        
    </fieldset>
    
</form>

</div>

<?php echo View::factory('system/template_fields', array('fields' => $fields));?>

<script type="text/javascript">
$(document).ready(function(){
    $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($row)?json_encode($row):'')); ?>);
});

</script>