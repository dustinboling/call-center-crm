<?php echo View::factory('application/notes', $notes)->render();?>

<h1 class="span16">File Punch Records</h1>
<div class="span16"><?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?></div>
<div class="clear"></div>

<div class="span16">
    <table class="zebra-striped" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th>User</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Total Time</th>
                <th colspan="2">Manage</th>
            </tr>
        </thead>
        <?php $total_time = 0; ?>
        <?php foreach ($punches as $p) { ?>
        <?php if ($p['id'] != $_SESSION['active_punch']['id']) { ?>
        <tr>
            <td><?php echo $p['first_name']; ?> <?php echo $p['last_name']; ?></td>
            <td><?php echo date('m/d/Y H:i:s', strtotime($p['in_time'])); ?></td>
            <td>
                <?php
                if (strlen($p['out_time'])) {
                    echo date('m/d/Y H:i:s', strtotime($p['out_time']));
                } else {
                    echo 'Open';
                }
                ?>
            </td>
            <td style="text-align:right;">
                <?php
                $total_time = $total_time + $p['punchtime'];
                echo number_format((($p['punchtime']/60)/60), 2);
                ?> Hours
            </td>
            <td style="text-align: center">
                <a href="/application/punch_update/<?php echo Uri::segment(3); ?>/<?php echo $p['id']; ?>" title="Edit Punch Record">
                    <img src="/img/icons/update.png">
                </a>
            </td>
            <td style="text-align: center">
                <a href="/application/punch_delete/<?php echo Uri::segment(3); ?>/<?php echo $p['id']; ?>" title="Delete Punch Record">
                    <img src="/img/icons/delete.png">
                </a>
            </td>
        </tr>
        <?php } ?>
        <?php } ?>
        <tr>
            <td colspan="3">&nbsp;</td>
            <td style="text-align:right;"><strong>Total:</strong> <?php echo number_format((($total_time/60)/60), 2); ?> Hours</td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
</div>