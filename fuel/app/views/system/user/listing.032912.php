<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Users</h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Type</th>
        <th>Department</th>
        <th>Name</th>
        <th>Email</th>
        <th></th>
    </tr>
    </thead>
    <?php foreach($users as $u):?>
    <tr>
        <td><?php echo $u['type'];?></td>
        <td><?php echo $u['department'];?></td>
        <td><?php echo $u['first_name']. ' ' .$u['last_name'];?></td>
        <td><?php echo $u['email'];?></td>
        <td width="20"><a href="/system/user/update/<?php echo $u['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
        <td width="20"><a href="/system/user/delete/<?php echo $u['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $u['first_name']. ' ' .$u['last_name'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
    </tr>
    <?php endforeach;?>
</table>    