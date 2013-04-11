<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Event Templates</h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped">
    
    <thead>
        <tr>
            <th>Name</th>
            <th colspan="2"></th>
        </tr>    
    </thead>
    
    <tbody>
        <?php foreach($events as $e):?>
        <tr>
            <td><?php echo $e['name'];?></td>
            <td width="20"><a href="/system/event/update/<?php echo $e['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
            <td width="20"><a href="/system/event/delete/<?php echo $e['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $e['name'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    
</table>

</div>