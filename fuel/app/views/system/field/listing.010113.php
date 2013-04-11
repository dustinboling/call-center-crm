<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo $object['name'];?> Fields</h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped table-condensed">
    
    <thead>
        <tr>
            <th>Name</th>
            <th>Template Code</th>
            <th colspan="4"></th>
        </tr>    
    </thead>
    
    <tbody>
        <?php foreach($fields as $f):?>
        <tr>
            <td><?php echo $f['name'];?></td>
            <td><?php if(!$f['structure']):?>{<?php echo $f['clean_name'];?>}<?php endif;?></td>
            <td width="60"><?php if($f['structure']):?><a href="/system/field/add/<?php echo $object['id'];?>/<?php echo $f['id'];?>" class="btn btn-small btn-success"><i class="icon-plus-sign icon-white"></i> Field</a><?php endif;?></td>
            <td width="85"><?php if($f['structure']):?><a href="/system/field/add/<?php echo $object['id'];?>/<?php echo $f['id'];?>" class="btn btn-small btn-success"><i class="icon-plus-sign icon-white"></i> Container</a><?php endif;?></td>
            <td width="20"><a href="/system/field/update/<?php echo $object['id'];?>/<?php echo $f['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
            <td width="20"><a href="/system/field/delete/<?php echo $object['id'];?>/<?php echo $f['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $f['name'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    
</table>

</div>