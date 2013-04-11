<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Forms</h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Name</th>

        <th colspan="2"></th>
    </tr>
    </thead>
    <?php foreach($forms as $f):?>
    <tr>
        <td><a href="/pdfs/<?php echo $f['file'];?>" target="_blank"><?php echo $f['name'];?></a></td>
        <td class="c" width="20"><a href="/system/form/update/<?php echo $f['id'];?>"><img src="/img/icons/update.png"></a></td>
        <td class="c" width="20"><a href="/system/form/delete/<?php echo $f['id'];?>"><img src="/img/icons/delete.png"></a></td>
    </tr>
    <?php endforeach;?>
</table>    