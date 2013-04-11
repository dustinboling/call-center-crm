<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Import Cases</h1>
<form action="/system/case/import" method="post" enctype="multipart/form-data">
    <input type="hidden" name="import_file" value="<?php echo $import_file;?>">
    <div class="row">
        <div class="span9">
            
            <div class="control-group">
                <label class="control-label">Import into Campaign</label>
                <div class="controls">
                    <select name="campaign_id">
                        <option value="0"></option>
                        <?php foreach($campaigns as $c):?>
                        <option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
    
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Import Data</th>
                    <th>Map to Field</th>
                </tr>
            <?php foreach($cols as $col_id => $col):?>
                <tr>
                    <td width="250"><?php echo substr($col, 0 , 50);?></td>
                    <td>
                        <select name="cols[<?php echo $col_id;?>]">
                            <option value=""></option>
                            <?php foreach($fields as $id => $value):?>
                            <option value="<?php echo $id;?>"><?php echo $value;?></option>
                            <?php endforeach;?>
                        </select>
                    </td>
                </tr>
            <?php endforeach;?>
            </table>

            <div class="form-actions">
                <button class="btn btn-primary">Import Cases</button>
            </div>
            
        </div>
    </div>
    
</form>   