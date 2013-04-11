<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> an Event Template</h1>

<?php echo View::Factory('system/tabs')->render();?>
<div class="r"><a id="tf_dialog" class="btn primary r">Show Available Fields</a></div>
<form action="/system/event/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>" method="post" id="form">
    
    <fieldset>
        
        <div class="clearfix">
            <label for="name">Name</label>
            <div class="input">
                <input type="text" name="name" class="span6">
            </div>
        </div>    
        
        <div class="clearfix">
            <label for="from">Title</label>
            <div class="input">
                <input type="text" name="title" class="span8">
            </div>
        </div>    
        
        <div class="clearfix">
            <label for="when">Date</label>
            <div class="input">
                <input type="text" name="when">
            </div>
        </div>
        
        <div class="clearfix">
            <label for="assign_to">Assign To</label>
            <div class="input">
                <input type="text" name="assign_to">
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