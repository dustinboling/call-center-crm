<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> a Group</h1>

<?php echo View::Factory('system/tabs')->render();?>
<form action="/system/distributiongroup/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>" method="post" id="form">
    
    <fieldset>
        
        <div class="clearfix">
            <label for="name">Name</label>
            <div class="input">
                <input type="text" name="name" class="span3">
            </div>
        </div>  
    </fieldset>  
    
    <fieldset>
        <legend>Group Users</legend>
        
        <?php 
            $split = floor(count($users) / 4);
            $l = 0;
        ?>
        
        <ul class="unstyled span3">
        <?php foreach($users as $u):?>
            <?php $l++;?>
            <li style="margin: 2px 0;"><input type="checkbox" name="users[]" value="<?php echo $u['id'];?>"> <?php echo $u['first_name'].' '.$u['last_name'];?></li>
            <?php if($l > $split):?></ul><ul class="unstyled span3"><?php $l = 0; endif;?>
        <?php endforeach;?>
        </ul>
        
    </fieldset>
    
    <div class="form-actions">
        <button class="btn primary">Save</button>
    </div>
        
  
</form>        

</div>

<script type="text/javascript">
$(document).ready(function(){
    
   $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($row)?json_encode($row):'')); ?>); 

});
</script>