<?php echo View::factory('application/notes', $notes)->render();?>

<div class="row-fluid">
<div class="span9">
    
    <h1>Send Forms</h1>

    <?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>

            <th colspan="3"></th>
        </tr>
        </thead>
        <?php foreach($forms as $f):?>
        <tr>
            <td><?php echo $f['name'];?></td>
            <td width="50"><a href="">eSign</a></td>
            <td width="50"><a href="">Fax</a></td>
            <td width="50"><a href="/form/download/<?php echo $f['id'];?>/<?php echo uri::segment(3);?>" target="_blank">Download</a></td>
        </tr>
        <?php endforeach;?>
    </table>    
    
</div>    
</div>