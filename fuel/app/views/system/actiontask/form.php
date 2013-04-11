<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> a Task for <?php echo $action['name'];?></h1>

<?php echo View::Factory('system/tabs')->render();?>


<form action="/system/actiontask/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>/<? (uri::segment(5) != ''? print '/'.uri::segment(5):'');?>" method="post" id="form">
    <input type="hidden" name="action_id" value="<?php echo uri::segment(4);?>">
    <fieldset>
        
        <div class="clearfix">
            <label for="task_id">Task</label>
            <div class="input">
                <select name="task_id" id="task_id">
                    <?php foreach($tasks as $t):?>
                        <option value="<?php echo $t['id'];?>"><?php echo $t['name'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>  
        
        <div class="clearfix">
            <label for="target_id">Target</label>
            <div class="input">
                <select name="target_id" id="target_id">
                    
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
       
       $("#task_id").change(function(e){
           manage_target();
       });
       
       manage_target();
       
    });
    
    function manage_target(){
        task_id = $("#task_id").val();
        $("#target_id").html('');
        $.get('/system/actiontask/targets/'+task_id, function(data){
            $.each(data, function(i, e) {
                $("#target_id").append('<option value="'+e.id+'">'+e.name+'</option>');
            });
        }, 'json');
    }
    
    
    
</script>    