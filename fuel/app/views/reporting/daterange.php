<?php
        (!isset($next)?$next=0:'');
?>

<div class="btn-toolbar" style="margin-bottom: 15px;">
    <div class="btn-group">
        <a href="<?php echo $uri;?>/yesterday/" class="btn">Yesterday</a>
        <a href="<?php echo $uri;?>" class="btn">Today</a>
        <?php if($next):?>
        <a href="<?php echo $uri;?>/tomorrow/" class="btn">Tomorrow</a>
        <?php endif;?>
    </div>
    <div class="btn-group">    
        <a href="<?php echo $uri;?>/last_week/" class="btn">Last Week</a>
        <a href="<?php echo $uri;?>/this_week/" class="btn">This Week</a>
        <?php if($next):?>
        <a href="<?php echo $uri;?>/next_week/" class="btn">Next Week</a>
        <?php endif;?>
    </div>    
    <div class="btn-group">    
        <a href="<?php echo $uri;?>/last_month/" class="btn">Last Month</a>
        <a href="<?php echo $uri;?>/this_month/" class="btn">This Month</a>
        <?php if($next):?>
        <a href="<?php echo $uri;?>/next_month/" class="btn">Next Month</a>
        <?php endif;?>
    </div>
</div>

<div>
    <form action="<?php echo $uri;?>/custom/" method="post" class="form-inline">
        <label>Custom  </label>
        <input type="text" class="input-small datepicker" name="start" placeholder="Start">
        <input type="text" class="input-small datepicker" name="end" placeholder="End">
        <input type="submit" class="btn btn-primary" value="Run">
    </form>
</div>
