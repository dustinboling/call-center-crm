<h1>Options for <?php echo $field['name'];?></h1>


<div class="span4">
    
    <div style="margin-bottom: 10px;">
        <div class="fr">
            <a href="/system/fieldoption/add/<?php echo uri::segment(4);?>" class="btn btn-success">Add an Option</a>
        </div>    
        
        <a href="/system/field/listing/1" class="btn">Back to Fields</a>
    </div>
    
    <table class="table table-striped table-condensed">
        <tbody class="sortable-options">
        <?php foreach($options as $o):?>

            <tr id="options_<?php echo $o['id'];?>">
                <td><?php echo $o['value'];?></td>
                <td width="30"><a href="/system/fieldoption/update/<?php echo $o['object_field_id'];?>/<?php echo $o['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
                <td width="30"><a href="/system/fieldoption/delete/<?php echo $o['object_field_id'];?>/<?php echo $o['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $o['value'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
                <td></td>
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
       
       $(".sortable-options tr").css('cursor', 'move');
       $(".sortable-options").sortable({helper: fixHelper, update: function(e, ui) { 
               $.post('/system/fieldoption/resort', {order:$(this).sortable('serialize')})
                    .success(function(data, textStatus, jqXHR){ console.log(data) })
           }});
           
    });
</script>  