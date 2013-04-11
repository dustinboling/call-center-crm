<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> a Call Template</h1>

<?php echo View::Factory('system/tabs')->render();?>
<div class="r"><a id="tf_dialog" class="btn primary r">Show Available Fields</a></div>
<form action="/system/call/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>" method="post" id="form">
    
    <fieldset>
        
        <div class="clearfix">
            <label for="name">Name</label>
            <div class="input">
                <input type="text" name="name" class="span8">
            </div>
        </div>    
        
        <div class="clearfix">
            <label for="from">From</label>
            <div class="input">
                <select name="from">
                    <?php foreach(\CallTracking\Model_Number::findByType('purchased') as $number):?>
                    <option value="<?php echo $number['id'];?>"><?php echo format::phone($number['number']);?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>    
        
        <div class="clearfix">
            <label for="to">To</label>
            <div class="input">
                <input type="text" name="to">
            </div>
        </div>
        
        <div class="clearfix">
            <label for="message">Message</label>
            <div class="input">
                <textarea name="message" class="span8" id="message"></textarea>
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