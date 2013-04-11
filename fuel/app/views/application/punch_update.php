<?php echo View::factory('application/notes', $notes)->render();?>

<h1 class="span16">File Punch Records</h1>
<div class="span16"><?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?></div>
<div class="clear"></div>

<form action="/application/punch_update/<?php echo Uri::segment(3); ?>/<?php echo Uri::segment(4); ?>" method="post" class="form-stacked">
    <fieldset>
        <table class="zebra-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Start Date</th>
                    <th>Start Time</th>
                    <th>End Date</th>
                    <th>End Time</th>
                    <th style="text-align: center"><a href="/application/punches/<?php echo Uri::segment(3); ?>" class="btn small">Back to Punch List</a></th>
                </tr>
            </thead>
            <tr>
                <td><?php echo $punch['first_name']; ?> <?php echo $punch['last_name']; ?></td>
                <td><input type="text" name="start_date" class="span2 datepicker" value="<?php echo date('m/d/Y', strtotime($punch['in_time'])); ?>"></td>
                <td><input type="text" name="start_time" class="span2" value="<?php echo date('g:i:s a', strtotime($punch['in_time'])); ?>"></td>
                <td>
                    <?php if (strlen($punch['out_time'])) { $out = date('m/d/Y', strtotime($punch['out_time'])); } else { $out = date('m/d/Y'); } ?>
                    <input type="text" name="end_date" class="span2 datepicker" value="<?php echo $out; ?>">
                </td>
                <td>
                    <?php if (strlen($punch['out_time'])) { $out = date('g:i:s a', strtotime($punch['out_time'])); } else { $out = date('g:i:s a'); } ?>
                    <input type="text" name="end_time" class="span2" value="<?php echo $out; ?>">
                </td>
                <td style="text-align: center"><input type="submit" value="Save Changes" class="btn primary" /></td>
            </tr>
        </table>
    </fieldset>
    <div class="clear"></div>
</form>
