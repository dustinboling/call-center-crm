<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Import Cases</h1>
<form action="/system/case/import" method="post" enctype="multipart/form-data">
    
    <div class="row">
        <div class="span9">
            
            <div class="control-group">
                <label class="control-label">Import File (csv only)</label>
                <div class="controls">
                <input type="file" name="import_file">
                </div>
            </div>

            <?php foreach($fields as $section_id => $cfs):?>   
                <?php $row = 1;?>   
                <?php if($section_id):?>
                <h2><?php echo $fgroups[$section_id]['name'];?></h2>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th colspan="3"><input type="checkbox" class="check_all"> Check All <?php echo $fgroups[$section_id]['name'];?> Fields
                    </tr>
                    <tr>
                        <?php $col = 1; ?>
                        <?php foreach($cfs as $container_id => $fs):?>
                            <?php foreach($fs as $f):?>
                                <?php if($row != 1 && $col == 4):?></tr><?php $row++; endif;?>
                                <?php if($col == 4):?><tr><?php $col = 1; endif;?>
                                <td style="width: 33%;"><input type="checkbox" name="ds[<?php echo $f['clean_name'];?>]" value="<?php echo $f['name'];?>"> <?php echo $f['name'];?></td>
                                <?php $col++;?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tr>
                </table>   
                <?php endif;?>
            <?php endforeach; ?>    
            
                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">Continue</button>
                </div>    
            
        </div>
    </div>
    
</form>

</div>

<script type="text/javascript">
    $('.check_all').click(function () {
        $(this).parents('table').find(':checkbox').attr('checked', this.checked);
    });
</script>