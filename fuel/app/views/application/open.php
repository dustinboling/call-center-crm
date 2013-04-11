<h1 class="span16">Open Files</h1>

<div class="span16">

    <?php echo View::factory('application/app_listing_tabs')->render(); ?>

    <table class="zebra-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Liability</th>
                <th>Last Punch</th>
                <th colspan="3" style="text-align: center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($punches)) { ?>
            <?php foreach ($punches as $p) { ?>
            <tr>
                <td><?php echo $applications[$p['application_id']]['last_name']; ?>, <?php echo $applications[$p['application_id']]['first_name']; ?></td>
                <td>$<?php echo number_format($applications[$p['application_id']]['tax_liability'], 2); ?></td>
                <td><?php echo date('m/d/Y H:i:s', strtotime($p['in_time'])); ?></td>
                <td style="text-align: center">
                    <a href="/application/view/<?php echo $applications[$p['application_id']]['id']; ?>" title="View and Edit Customer Contract"><img src="/img/icons/update.png"></a>
                </td>
                <td style="text-align: center">
                    <?php if (isset($_SESSION['punches'][$applications[$p['application_id']]['id']])) { ?>
                    <a href="/application/clockout/<?php echo $applications[$p['application_id']]['id']; ?>" title="Clock Out"><img src="/img/icons/clock_stop.png"></a>
                    <?php } else { ?>
                    <a href="/application/view/<?php echo $applications[$p['application_id']]['id']; ?>" title="Clock In"><img src="/img/icons/clock_start.png"></a>
                    <?php } ?>
                </td>
                <td style="text-align: center">
                    <a href="/application/delete/<?php echo $applications[$p['application_id']]['id']; ?>" title="Remove Customer Contract" onclick="return conf('Are you sure you want to delete this contract?\nThis cannot be undone.')"><img src="/img/icons/delete.png"></a>
                </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
                <td colspan="7">You have no open files</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>