<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Import Templates</h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped">
    
    <thead>
        <tr>
            <th>Name</th>
            <th>Uri</th>
            <th>Active</th>
            <th colspan="2"></th>
        </tr>    
    </thead>
    
    <tbody>
        <?php foreach($imports as $i):?>
        <tr>
            <td><?php echo $i['name'];?></td>
            <td><small>http://<?php echo $_SERVER['HTTP_HOST'];?>/api/import/<?php echo $i['id'];?>/<?php echo $i['hash'];?></small></td>
            <td><?php echo ($i['active']?'Yes':'No');?></td>
            <td width="20"><a href="/system/import/update/<?php echo $i['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
            <td width="20"><a href="/system/import/delete/<?php echo $i['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $i['name'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    
</table>

</div>