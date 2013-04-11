<div id="template_fields">
    
        <div style="height: 400px; overflow: scroll; overflow-x: hidden;">
            <table class="table table-striped">
                <?php foreach($fields as $f):?>
                <tr>
                    <td width="150"><?php echo $f['name'];?></td>
                    <td width="150">{<?php echo $f['clean_name'];?>}</td>
                </tr>    
                <?php endforeach;?>
            </table>
        </div>

</div>

<script type="text/javascript">
    $("#tf_dialog").click(function(e){ $("#template_fields").dialog('open'); });
    $("#template_fields").dialog({title: 'Template Fields', width: 500, height: 450, autoOpen: false});
</script>    