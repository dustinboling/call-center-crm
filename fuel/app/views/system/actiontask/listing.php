<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Tasks for <?php echo $action['name'];?></h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped">
    
    <thead>
        <tr>
            <th>Task</th>
            <th colspan="3"></th>
        </tr>    
    </thead>
    
    <tbody>
        <?php foreach($tasks as $t):?>
        <tr>
            <td><strong><?php echo $t['name'];?></strong>: <?php echo $t['target'];?></td>
            <td width="20"><a href="/system/actiontask/update/<?php echo $t['action_id'];?>/<?php echo $t['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
            <td width="20"><a href="/system/actiontask/delete/<?php echo $t['action_id'];?>/<?php echo $t['id'];?>" onclick="return confirm('Are you sure you want to delete this?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    
</table>

</div>
