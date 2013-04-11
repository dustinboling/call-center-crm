<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Milestones</h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped">
    
    <thead>
        <tr>
            <th>Milestone</th>
            <th colspan="2"></th>
        </tr>    
    </thead>
    
    <tbody id="sortable">
        <?php foreach($milestones as $m):?>
        <tr data-sid="<?php echo $m['id'];?>">
            <td><?php echo $m['name'];?></td>
            <td width="20"><a href="/system/milestone/update/<?php echo $m['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
            <td width="20"><a href="/system/milestone/delete/<?php echo $m['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $m['name'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    
</table>