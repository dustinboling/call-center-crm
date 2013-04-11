<h1>Customers</h1>

<div>
    <div class="filter_bar clearfix">
        <form style="margin: 0pt; padding: 0pt;" method="GET" action="/application/listing">
            Search Customers:
            <input type="text" name="q" class="span7" autocomplete="off">
            <button type="submit" class="btn">Find</button>
        </form>
    </div>
</div>
<div class="clear"></div>

<div>

    <?php echo View::factory('application/app_listing_tabs')->render(); ?>

    <table class="table table-condensed table-striped">
        <thead>
            <tr>
                <th>Payment</th>
                <th>Priority</th>
                <th>Name</th>
                <th>Status</th>
                <th>Last Action</th>
                <th>Liability</th>
                <th colspan="3" style="text-align: center"><a href="/application/add" class="btn success small">Add New</a></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applications as $a) { ?>
            <tr>
                <td><?php echo format::payment_status($a['payment_status_id']);?></td>
                <td><?php echo format::priority_level($a['priority_level']);?></td>
                <td><span title="Time: <?php if(isset($time_spent[$a['id']])){ echo number_format((($time_spent[$a['id']] / 60) / 60), 2); }else{ echo '0'; } ?>  Hours spent on file"><?php echo $a['last_name']; ?>, <?php echo $a['first_name']; ?></span></td>
                <td><?php echo $a['current_status']; ?></td>
                <td><?php (!empty($a['last_action'])?print date('m/d/Y', strtotime($a['last_action'])):''); ?></td>
                <td>$<?php echo number_format($a['tax_liability'], 2); ?></td>
                <td style="text-align: center">
                    <a href="/application/view/<?php echo $a['id']; ?>" title="View and Edit Customer File"><img src="/img/icons/update.png"></a>
                </td>
                <td style="text-align: center">
                    <?php if (isset($_SESSION['punches'][$a['id']])) { ?>
                    <a href="/application/clockout/<?php echo $a['id']; ?>" title="Clock Out"><img src="/img/icons/clock_stop.png"></a>
                    <?php } else { ?>
                    <a href="/application/view/<?php echo $a['id']; ?>" title="Clock In"><img src="/img/icons/clock_start.png"></a>
                    <?php } ?>
                </td>
                <td style="text-align: center">
                    <a href="/application/delete/<?php echo $a['id']; ?>" title="Remove Customer File" onclick="return conf('Are you sure you want to delete this contract?\nThis cannot be undone.')"><img src="/img/icons/delete.png"></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
    <?php echo View::factory('pagination', $pagination)->render();?>

</div>