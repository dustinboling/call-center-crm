<?php echo View::factory('application/notes', $notes)->render();?>
<div class="row-fluid">
<div class="span9">
    
    <h1>Activity</h1>
    <?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Activity Date</th>
                <th>Activity</th>
                <th>Performed By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($activities as $a):?>
            <tr>
                <td width="125"><?php echo date('m/d/y g:ia', strtotime($a['ts']));?></td>
                <td><?php echo $a['message'];?></td>
                <td><?php echo $a['name'];?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
</div>    
