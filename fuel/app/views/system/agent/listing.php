<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Agents</h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Name</th>
        <th>Type</th>
        <th>CAF</th>
        <th>License #</th>
        <th colspan="2"></th>
    </tr>
    </thead>
    <?php foreach($agents as $a):?>
    <tr>
        <td><?php echo $a['first_name'].' '.$a['last_name'];?></td>
        <td><?php echo $a['type'];?></td>
        <td><?php echo $a['caf'];?></td>
        <td><?php echo $a['license_number'];?></td>
        <td class="c"><a href="/system/agent/update/<?php echo $a['id'];?>"><img src="/img/icons/update.png"></a></td>
        <td class="c"><a href="/system/agent/delete/<?php echo $a['id'];?>"><img src="/img/icons/delete.png"></a></td>
    </tr>
    <?php endforeach;?>
</table>    