<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo $group['name'];?> Statuses</h1>

<?php echo View::Factory('system/status/tabs')->render();?>

<table class="table table-striped">
    
    <thead>
        <tr>
            <th>Level</th>
            <th width="125">Milestone</th>
            <th>Status</th>
            <th colspan="2"></th>
        </tr>    
    </thead>
    
    <tbody id="sortable">
        <?php foreach($statuses as $s):?>
        <tr data-sid="<?php echo $s['id'];?>">
            <td width="50" class="c"><?php echo $s['level'];?></td>
            <td><?php echo $s['milestone'];?></td>
            <td><?php echo $s['name'];?></td>
            <td width="20"><a href="/system/status/update/<?php echo $s['group_id'];?>/<?php echo $s['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
            <td width="20"><a href="/system/status/delete/<?php echo $s['group_id'];?>/<?php echo $s['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $s['name'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    
</table>

</div>

<script type="text/javascript">
$(document).ready(function(){
    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };
    
    $("#sortable tr").css('cursor', 'move');
    
    $("#sortable").sortable({
            helper: fixHelper,
            stop: function(e, ui) { 
                status_id = ui.item.attr('data-sid');
                $.get('/system/status/resort/'+status_id+'/'+(ui.item.index()+1));
                }
    });
    
});
</script>