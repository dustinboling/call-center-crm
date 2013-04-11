<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Actions</h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped">
    
     <thead>
        <tr>
            <th>ID</th>
            <th>View ID</th>
	    <th>Action</th>
            <th colspan="4"></th>
        </tr>    
    </thead>
    
    <tbody>
        <?php foreach($actions as $a):?>
        <tr>
            <td width="50"><?php echo $a['id'];?></td>
            <td><?php echo $a['view_id'];?></td>
		<td><?php echo $a['name'];?></td>
            <td width="20"><a href="/system/actiontask/listing/<?php echo $a['id'];?>"><img src="/img/icons/cog.png" alt="tasks"></a></td>
            <td width="20"><a href="/system/action/update/<?php echo $a['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
            <td width="20"><a href="/system/action/delete/<?php echo $a['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $a['name'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    
</table>

</div>