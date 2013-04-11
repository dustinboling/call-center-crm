<?php echo View::Factory('reporting/menu')->render();?>

<div class="span10">

<h1>Commission Detail: <?php echo uri::segment(4);?></h1> 
<p><a href="<?php echo $_SERVER['HTTP_REFERER'];?>">Back to Commission Summary</a></p>
    
<table class="table table-striped">
    <thead>
    <tr>
        <th>Transaction ID</th>
        <th class="r">Amount</th>
        <th>Status</th>
        <th class="r">Commission</th>
        <th>Commission Paid</th>
        <th>Payment Date</th>
    </tr>
    </thead>
<?php foreach($payments as $r):?>
    <tr>
        <td><?php echo $r['transaction_id'];?></td>
        <td width="100" class="r">$<?php echo number_format($r['amount'],2);?></td>
        <td><?php echo $r['status'];?></td>
        <td width="100" class="r">$<?php echo number_format($r['commission'],2);?></td>
        <td><?php if(!empty($r['comission_paid'])):?>Yes<?php else: ?>No<?php endif;?></td>
        <td><?php echo date('m/d/y g:ia', strtotime($r['created']));?></td>
    </tr>
<?php endforeach; ?>
</table>
</div>