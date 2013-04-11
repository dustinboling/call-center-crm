<?php
    
    $payments = 0;
    $commissions = 0;

?>    

<?php echo View::Factory('reporting/menu')->render();?>

<div class="span10">

<h1>Commissions Summary: <?php echo $start->format('m/d/y');?> - <?php echo $end->format('m/d/y');?></h1>

<?php echo View::factory('reporting/commissions/filters', array('users' => $users, 'start' => $start, 'end' => $end));?>
    
<table class="table table-striped">
    <thead>
    <tr>
        <th>Case&nbsp;ID</th>
        <th>Name</th>
        <th class="r">Total Fees</th>
        <th class="r">Payments</th>
        <th class="r">Balance Due</th>
        <th class="r">Commissions</th>
        <th>Payments Made</th>
        <th>Last Payment Date</th>
    </tr>
    </thead>
<?php foreach($result as $r):?>
    <?php
    
        $payments += $r['amount'];
        $commissions += $r['commissions'];
    
    ?>
    <tr class="payments" data-id="<?php echo $r['id'];?>">
        <td><?php echo $r['id'];?></td>
        <td><?php echo $r['first_name'].' '.$r['last_name'];?></td>
        <td width="100" class="r">$<?php echo number_format($r['total_fees'],2);?></td>
        <td width="100" class="r">$<?php echo number_format($r['amount'],2);?></td>
        <td width="100" class="r"><?php echo number_format($r['total_fees']-$r['amount'],2);?></td>
        <td width="100" class="r">$<?php echo number_format($r['commissions'],2);?></td>
        <td width="100" class="c"><?php echo $r['payments_made_count'];?></td>
        <td><?php echo date('m/d/y g:ia', strtotime($r['last_payment']));?></td>
    </tr>
<?php endforeach; ?>
    <tr>
        <th colspan="3">Totals</th>
        <th class="r">$<?php echo number_format($payments,2);?></th>
        <th></th>
        <th class="r">$<?php echo number_format($commissions,2);?></th> 
        <th colspan="2"></th>
    </tr>
</table>
    
</div>

<script type="text/javascript">
    $(function(){
       $(".payments td").click(function(){
          window.location = '/reporting/commissions/detail/'+$(this).parent().data('id'); 
       });
       
    });
</script>    
