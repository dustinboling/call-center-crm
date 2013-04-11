<h1><?php echo $case['first_name'] . ' ' . $case['last_name'];?></h1>

<?php echo $header;?>

<ul class="nav nav-tabs">
    <li><a href="/case/view/<?php echo uri::segment(3);?>/#overview">Overview</a></li>
    <li><a href="/case/update/<?php echo uri::segment(3);?>">Case Info</a></li>
    <li class="dropdown active"><a class="dropdown-toggle" data-toggle="dropdown">Payments <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/payment/process/<?php echo uri::segment(3);?>">Process Next Payment</a>
            <li><a href="/payment/manage/<?php echo uri::segment(3);?>">Payment Plan</a>
        </ul>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">Documents <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/esign/document/listing/<?php echo uri::segment(3);?>">ESign Documents</a>
            <li><a href="/case/view/<?php echo uri::segment(3);?>/#forms">Forms</a>
            <li><a href="/case/view/<?php echo uri::segment(3);?>/#documents">Uploaded Documents</a>
        </ul>
    </li>    
    <li><a href="/case/view/<?php echo uri::segment(3);?>/#activity">Activity</a></li>
</ul>

<h2>Payment Plan</h2>

<?php if(round($total_fees,2) != round($scheduled_payments + $total_payments,2)):?>
<form action="/payment/manage/<?php echo uri::segment(3);?>" method="post">
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Total Fees</th>
            <th>Received</th>
            <th>Due</th>
            <th>Scheduled</th>
            <th>Unplanned</th>
            <th>Create Plan By</th>
            <th>Payment Frequency</th>
            <?php if(empty($last_pending_date)):?>
            <th>Start Date</th>
            <?php endif;?>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                $<?php echo number_format($total_fees,2);?>
            </td>
            <td>
                $<?php echo number_format($total_payments,2);?>
            </td>
            <td>
                $<?php echo number_format($total_fees - $total_payments,2);?>
            </td>
            <td>
                $<?php echo number_format($scheduled_payments,2);?>
            </td>
            <td>
                <span style="color: #f00;">$<?php echo number_format($total_fees - ($scheduled_payments + $total_payments),2);?></span>
            </td>
            <?php /*
            <td>
                <div class="input-prepend">
                    <span class="add-on">$</span>
                    <input type="text" name="down_payment" class="input-medium">
                </div>
            </td>
             */?>
            <td width="450">
                <select name="generate_by" id="generate_by">
                    <option value="number">Number of Payments</option>
                    <option value="amount">Amount of Payment</option>
                </select>
                <select name="number_payments" class="input-medium" id="number_payment">
                    <?php foreach(range(1,24) as $r):?>
                    <option value="<?php echo $r;?>"><?php echo $r;?> Payment<?php ($r != 1?print 's':'');?></option>
                    <?php endforeach;?>
                </select>
                <div class="input-prepend hide" id="amount_payment">
                    <span class="add-on">$</span>
                    <input type="text" name="payment_amount" class="input-medium">
                </div>
            </td>
            <td class="c">
                <select name="payment_frequency" class="input-small">
                    <option value="1 month">Monthly</option>
                    <option value="2 weeks">Bi-Monthly</option>
                    <option value="1 week">Weekly</option>
                </select>
            </td>
            <?php if(empty($last_pending_date)):?>
            <td class="c">
                <input type="text" name="start_date" class="datepicker input-small">
            </td>
            <?php endif;?>
            <td width="80"><button type="submit" name="generate" class="btn btn-primary">Generate</button></td>
        </tr>
    </tbody>
</table>
</form>
<?php endif;?>

<?php if(count($payments)):?>
<p>
    <?php if($total_fees != $total_payments):?>
    <a class="btn btn-danger" href="/payment/reset/<?php echo uri::segment(3);?>" onclick="confirm('This will delete all non-processed payments and allow a new schedule to be created. Are you sure?');">Reset Payment Plan</a>
    <?php endif;?>
    <a class="btn btn-success" href="/payment/process/<?php echo uri::segment(3);?>">Process Next Payment</a>
</p>
  
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>Date Due/Processed</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Note</th>
        </tr>
    </thead>
    <?php $n=1;?>
    <?php foreach($payments as $p):?>
        <?php $p['number'] = $n;?>
        <tr class="payment_<?php echo $p['status'];?>">
        <td>Payment <?php echo $p['number'];?></td>
        <td><?php echo (!empty($p['date_received'])?date('m/d/Y g:ia', strtotime($p['date_received'])):date('m/d/Y', strtotime($p['date_due'])));?></td>
        <td>$<?php echo (!empty($p['amount_received'])&&$p['amount_received']>0? number_format($p['amount_received'],2):number_format($p['amount'],2));?></td>
        <td><?php echo ucwords($p['status']);?></td>
        <td><?php echo $p['received_note'];?></td>
        <td width="25"><a href="/payment/update/<?php echo $p['case_id'];?>/<?php echo $p['id'];?>"><i class="icon-pencil"></i></td>
</tr>
    <?php $n++;?>
    <?php endforeach;?>
<?php /*    
    <tr>
        <td><button class="btn btn-success">Add A Payment</button></td>
        <td colspan="3"></td>
    </tr>
 */
?>
</table>

<?php endif;?> 

<form action="/case/update/<?php echo uri::segment(3);?>?redirect=/payment/manage/<?php echo uri::segment(3);?>" method="post" class="form" id="form">
    <?php echo str_replace(array('tab-content','tab-pane'), '', View::factory('case/fields', array('fields' => $fields, 'fgroups' => $fgroups, 'options' => $options))->render());?>
</form>    

<?php foreach(array('federal_owed','federal_not_filed','state_owed','state_not_filed') as $field){ if(isset($case[$field])){ unset($case[$field]); } } ?>

<script type="text/javascript">
$(function(){
    
    $("#form").populate(<?php echo (isset($_POST['total_fees'])?json_encode($_POST):(isset($case)?json_encode($case):'')); ?>);
    
    $("#generate_by").change(function(){
        v = $(this).val();
        if(v == 'amount'){
            $("#amount_payment").css('display', 'inline-block');
            $("#number_payment").hide();
        }else if(v == 'number'){
            $("#amount_payment").hide();
            $("#number_payment").show();
        }
    });
    
    var saved_total = 0;
    $("input[name=total_fees]").focus(function(){
        saved_total = $(this).val();
    }).blur(function(){
        $(this).val(saved_total);
    })
    
    $("input[name=tax_file_setup_fee]").blur(function(e){ updateTotalFees(); });
    $("input[name=case_evaluation_fee]").blur(function(e){ updateTotalFees(); });
    $("input[name=tax_return_filing_services_fee]").blur(function(e){ updateTotalFees(); });
    $("input[name=tax_settlement_services_fee]").blur(function(e){ updateTotalFees(); });
    
    $("#form").submit(function(e){
        updateTotalFees();
        return true;
    })
});

function updateTotalFees(){
    
    fee1 = 0;
    if(!isNaN(parseInt($("input[name=tax_file_setup_fee]").val()))){
        fee1 = parseInt($("input[name=tax_file_setup_fee]").val());
    }
    fee2 = 0;
    if(!isNaN(parseInt($("input[name=tax_settlement_services_fee]").val()))){
        fee2 = parseInt($("input[name=tax_settlement_services_fee]").val());
    }
    fee3 = 0;
    if(!isNaN(parseInt($("input[name=tax_return_filing_services_fee]").val()))){
        fee3 = parseInt($("input[name=tax_return_filing_services_fee]").val());
    }
    fee4 = 0;
    if(!isNaN(parseInt($("input[name=case_evaluation_fee]").val()))){
        fee4 = parseInt($("input[name=case_evaluation_fee]").val());
    }

    total_fees = fee1 + fee2 + fee3 + fee4; 
    $("input[name=total_fees]").val(total_fees);
    
}
</script>