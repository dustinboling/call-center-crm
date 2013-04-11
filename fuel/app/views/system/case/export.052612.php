<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Export Cases</h1>
<form action="/system/case/export" method="post">
    
    <div class="row">
        <div class="span9">
        <table class="table table-striped table-bordered">
            <tr>
                <th>Campaigns</th>
                <th>Statuses</th>
                <th>Duplicates</th>
            </tr>
            <tr>
                <td style="width: 33%;">
                    
                    <ul class="unstyled">
                        <li class="alert alert-info"><input type="checkbox" class="check_all_td"> <strong>Select All Campaigns</strong></li>
                    <?php foreach($campaigns as $c):?>
                        <li><input type="checkbox" name="campaign_ids[]" value="<?php echo $c['id'];?>"> <?php echo $c['name'];?>
                    <?php endforeach;?>
                    </ul>
                </td>
                <td style="width: 33%;">
                    <ul class="unstyled">
                        <li class="alert alert-info"><input type="checkbox" class="check_all_td"> <strong>Select All Statuses</strong></li>
                        <li><input type="checkbox" name="status_ids[]" value="0"> (!) Incorrect or No Status</li>
                    <?php foreach($statuses as $s):?>
                        <li><input type="checkbox" name="status_ids[]" value="<?php echo $s['id'];?>"> <?php echo $s['name'];?>
                    <?php endforeach;?>
                    </ul>
                </td>
                <td style="width: 33%;">
                    <select name="is_duplicate">
                        <option value="0">No Duplicates</option>
                        <option value="1">Duplicates Only</option>
                    </select>
                </td>
            </tr>
        </table>
        
        <h2>System Fields</h2>    
        <table class="table table-bordered table-striped">
            <tr>
                <th colspan="3"><input type="checkbox" class="check_all"> Check All System Fields
            </tr>
            <tr>
                <td style="width: 33%;"><input type="checkbox" name="db[]" value="id"> Case ID</td>
                <td style="width: 33%;"><input type="checkbox" name="db[]" value="status_id"> Status ID</td>
                <td style="width: 33%;"><input type="checkbox" name="db[]" value="campaign_id"> Campaign ID</td>
            </tr>
            <tr>
                <td style="width: 33%;"><input type="checkbox" name="db[]" value="sales_rep_id"> Sales Rep ID</td>
                <td style="width: 33%;"><input type="checkbox" name="db[]" value="action_count"> Action Count</td>
                <td style="width: 33%;"><input type="checkbox" name="db[]" value="last_action"> Last Action Date</td>
            </tr>
            <tr>
                <td style="width: 33%;"><input type="checkbox" name="db[]" value="created"> Created Date</td>
                <td></td>
                <td></td>
            </tr>
        </table>    
            
        
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
                            <td style="width: 33%;"><input type="checkbox" name="ds[]" value="<?php echo $f['clean_name'];?>"> <?php echo $f['name'];?></td>
                            <?php $col++;?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tr>
            </table>   
            <?php endif;?>
        <?php endforeach; ?>    
            
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Run Export</button>
            </div>    
            
        </div>
    </div>
    
</form>
</div>


<script type="text/javascript">
    $('.check_all').click(function () {
        $(this).parents('table').find(':checkbox').attr('checked', this.checked);
    });
    $('.check_all_td').click(function () {
        $(this).parents('td').find(':checkbox').attr('checked', this.checked);
    });
</script>