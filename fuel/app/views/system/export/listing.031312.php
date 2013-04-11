<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Export Templates</h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped">
    
    <thead>
        <tr>
            <th>Name</th>
            <th colspan="2"></th>
        </tr>    
    </thead>
    
    <tbody>
        <?php foreach($exports as $e):?>
        <tr>
            <td><?php echo $e['name'];?></td>
            <td><?php echo $e['type'];?></td>
            <td width="20"><a href="/system/export/update/<?php echo $e['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
            <td width="20"><a href="/system/export/delete/<?php echo $e['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $e['name'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    
</table>

</div>