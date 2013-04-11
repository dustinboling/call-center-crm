<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Action Groups</h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped">
    
    <thead>
        <tr>
            <th>Name</th>
            <th colspan="2"></th>
        </tr>    
    </thead>
    
    <tbody>
        <?php foreach($groups as $g):?>
        <tr>
            <td><?php echo $g['name'];?></td>
            <td width="20"><a href="/system/actiongroup/update/<?php echo $g['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
            <td width="20"><a href="/system/actiongroup/delete/<?php echo $g['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $g['name'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    
</table>

</div>