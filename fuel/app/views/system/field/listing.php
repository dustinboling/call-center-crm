<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo $object['name'];?> Fields</h1>

<div style="margin-bottom: 10px;"><a href="/system/fieldgroup/add/section/<?php echo uri::segment(4);?>" class="btn btn-success btn-small">Add Section</a></div>
<ul class="unstyled" id="sortable-sections">
<?php foreach($sections as $s):?>
    <li id="sections_<?php echo $s['id'];?>">
    <h2 class="fl"><?php echo $s['name'];?></h2>
    
    <div class="fr">
        <a href="/system/fieldgroup/add/container/<?php echo uri::segment(4);?>/<?php echo $s['id'];?>" class="btn btn-mini btn-success fl" style="margin-right: 10px;">Add Container</a>
        <div class="btn-group fl">
            <a href="/system/fieldgroup/update/section/<?php echo uri::segment(4);?>/<?php echo $s['id'];?>" class="btn btn-mini">Update</a>
            <a href="/system/fieldgroup/delete/section/<?php echo uri::segment(4);?>/<?php echo $s['id'];?>" class="btn btn-mini btn-danger">Delete</a>
        </div>
    </div>
    
    <div class="clear"></div>
    <hr>

    <?php if(isset($containers[$s['id']]) && !empty($containers[$s['id']])):?>
    <ul class="unstyled sortable-containers">
        <?php foreach($containers[$s['id']] as $c):?>

            <li id="containers_<?php echo $c['id'];?>">
                <h3 class="fl"><?php echo $c['name'];?></h3>

                <div class="fr">
                    <a href="/system/field/add/<?php echo $object['id'];?>/<?php echo $c['id'];?>" class="btn btn-mini btn-success fl" style="margin-right: 10px;">Add Field</a>
                    <div class="btn-group fl">
                        <a href="/system/fieldgroup/update/container/<?php echo uri::segment(4);?>/<?php echo $c['id'];?>" class="btn btn-mini">Update</a>
                        <a href="/system/fieldgroup/delete/container/<?php echo uri::segment(4);?>/<?php echo $c['id'];?>" class="btn btn-mini btn-danger">Delete</a>
                    </div>

                </div>

            <div class="clear"></div>

            <?php if(isset($fields[$s['id']][$c['id']]) && !empty($fields[$s['id']][$c['id']])):?>
                <table class="table table-striped table-condensed">
                    <tbody class="sortable-fields">
                <?php foreach($fields[$s['id']][$c['id']] as $f):?>

                    <tr id="fields_<?php echo $f['id'];?>">
                        <td width="100"><?php if($f['field_type_id'] == 16):?><a href="/system/fieldoption/listing/<?php echo $f['id'];?>" class="btn btn-mini">Set Options</a><?php endif;?></td>
                        <td width="30%"><?php echo $f['name'];?></td>
                        <td width="58%">{<?php echo $f['clean_name'];?>}</td>
                        <td width="30"><a href="/system/field/update/<?php echo $object['id'];?>/<?php echo $f['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
                        <td width="30"><a href="/system/field/delete/<?php echo $object['id'];?>/<?php echo $f['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $f['name'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
                        <td></td>
                    </tr>

                <?php endforeach;?>
                    </tbody>
                </table>
            <?php endif;?>
        </li>

        <?php endforeach;?>    
    </ul>
    <?php endif;?>
    </li>
<?php endforeach;?>
</ul>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
       
       $(".sortable-fields tr").css('cursor', 'move');
       $(".sortable-fields").sortable({helper: fixHelper, update: function(e, ui) { 
               $.post('/system/field/resort', {order:$(this).sortable('serialize')})
                    .success(function(data, textStatus, jqXHR){ console.log(data) })
           }});
       
       $(".sortable-containers li").css('cursor', 'move');
       $(".sortable-containers").sortable({helper: fixHelper, update: function(e, ui) { 
               $.post('/system/fieldgroup/resort/container', {order:$(this).sortable('serialize')})
                    .success(function(data, textStatus, jqXHR){ console.log(data) })
           }});
       
       $("#sortable-sections").css('cursor', 'move');
       $("#sortable-sections").sortable({helper: fixHelper, update: function(e, ui) { 
           $.post('/system/fieldgroup/resort/section', {order:$(this).sortable('serialize')})
                    .success(function(data, textStatus, jqXHR){ console.log(data) })
       }});
       
    });
</script>    