<h1><?php echo $case['first_name'] . ' ' . $case['last_name'];?></h1>

<?php echo $header;?>

<ul class="nav nav-tabs">
    <li><a href="/case/view/<?php echo uri::segment(3);?>/#overview">Overview</a></li>
    <li><a href="/case/update/<?php echo uri::segment(3);?>">Case Info</a></li>
    <li class="dropdown active"><a class="dropdown-toggle" data-toggle="dropdown">Payments <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/payment/process/<?php echo uri::segment(3);?>">Process Next Payment</a></li>
            <li><a href="/payment/manage/<?php echo uri::segment(3);?>">Payment Plan</a></li>
            <li><a href="/sfpayment/case/<?php echo uri::segment(3);?>">Payments Received</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">Documents <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/esign/document/listing/<?php echo uri::segment(3);?>">ESign Documents</a></li>
            <li><a href="/case/view/<?php echo uri::segment(3);?>/#forms">Forms</a></li>
            <li><a href="/case/view/<?php echo uri::segment(3);?>/#documents">Uploaded Documents</a></li>
        </ul>
    </li>    
    <li><a href="/case/view/<?php echo uri::segment(3);?>/#activity">Activity</a></li>
</ul>

<h2>Payments</h2>

<?php if(!count($payments)):?>

<p><strong>No payments have been received from Salesforce.</strong></p>

<?php else:?>

<table class="table table-striped">
    
    <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Amount</th>
            <th>Commission</th>
            <th>Response</th>
            <th>Created</th>
        </tr>
    </thead>
    <?php
        $total_amount = 0;
        $total_commission = 0;
    ?>
    <?php foreach($payments as $p):?>
    <tr>
        <td><?php echo $p['transaction_id'];?></td>
        <td>$<?php echo $p['amount'];?></td>
        <td>$<?php echo $p['commission'];?></td>
        <td><?php echo $p['status'];?></td>
        <td><?php echo date('m/d/y g:ia', strtotime($p['created']));?></td>
    </tr>
    <?php $total_amount += $p['amount'];?>
    <?php $total_commission += $p['commission'];?>
    <?php endforeach;?>
    <tr>
        <td><strong>Totals:</strong></td>
        <td><strong>$<?php echo number_format($total_amount,2);?></strong></td>
        <td><strong>$<?php echo number_format($total_commission,2);?></strong></td>
        <td colspan="2"></td>
    </tr>
    
</table>

<?php endif; ?>
