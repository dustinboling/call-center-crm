<div>
    <form action="/reporting/commissions/summary" method="post" class="form-inline">
        
        <?php if(Model_Account::getType() != 'User'):?>
        <select name="rep_id" class="input-medium">
            <option value="">All Reps</option>
            <?php foreach($users as $u):?>
            <option value="<?php echo $u['id'];?>" <?php (!empty($_GET['rep_id']) && $_GET['rep_id'] == $u['id']?print ' selected':'');?>><?php echo $u['first_name'] . ' ' . $u['last_name'];?></option>
            <?php endforeach;?>
        </select>
        <?php endif;?>
        
        <input type="text" class="input-small datepicker" name="start" placeholder="Start" value="<?php echo $start->format('m/d/Y');?>">
        <input type="text" class="input-small datepicker" name="end" placeholder="End" value="<?php echo $end->format('m/d/Y');?>">
        <input type="submit" class="btn btn-primary" value="Run">
    </form>
</div>