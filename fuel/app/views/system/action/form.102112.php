<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> an Action</h1>

<?php echo View::Factory('system/tabs')->render();?>


<form action="/system/action/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>" method="post" id="form">
    
    <fieldset>
        
        <div class="clearfix">
            <label for="name">Name</label>
            <div class="input">
                <input type="text" name="name" class="span8">
            </div>
        </div>  
        
        <div class="clearfix">
            <label for="set_task">Enforce Appointment With Action?</label>
            <div class="input">
                <select name="set_task" class="input-small">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
        </div>  
        
		<div class="clearfix">
            <label for="in_batch">Is Action Listed on Batch Menu?</label>
            <div class="input">
                <select name="in_batch" class="input-small">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
		</div>
		
		<div class="clearfix">
            <label for="view_id">Listing View ID</label>
            <div class="input">
                <select name="view_id" class="input-small">
                    <option value="0">0</option>
                    <option value="1">1</option>
		    <option value="2">2</option>
                    <option value="3">3</option>
		    <option value="4">4</option>
                    <option value="5">5</option>
		    <option value="6">6</option>
                    <option value="7">7</option>
	            <option value="8">8</option>
                    <option value="9">9</option>
		    <option value="10">10</option>
                 </select>
            </div>
			</div>
		
		
        <div class="actions">
            <button class="btn primary">Save</button>
        </div>
        
    </fieldset>    

</div>

<script type="text/javascript">
    
    $(document).ready(function(){

        $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($row)?json_encode($row):'')); ?>); 
        
    });

</script>