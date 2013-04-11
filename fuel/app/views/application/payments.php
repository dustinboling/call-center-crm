<?php echo View::factory('application/notes', $notes)->render();?>

<div class="row-fluid">
<div class="span9">

<h1>Customer Payments</h1>
<?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>
<div class="clear"></div>

<?php if (empty($payments)) { ?>
<div>Fees and a Payment Schedule must be set up first</div>
<?php } else { ?>    

<form action="/application/payments/<?php echo Uri::segment(3); ?>" method="post" class="">
    <fieldset>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>
                        Total Pinnacle Fees:
                        $<?php echo number_format(($fees['eval_fee'] + $fees['file_setup_fee'] + $fees['file_service_fee'] + $fees['settlement_fee']), 2, '.', ''); ?>
                    </h2>
                </td>
            </tr>
        </table>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="7">
                    <h2>Payments</h2>
                </td>
            </tr>
            <?php foreach ($payments as $v) { ?>
            <tr>
                <td>
                    <div class="clearfix">
                        <label>Payment <?php echo $v['payment_number']; ?></label>
                        Amount: <?php echo number_format($v['amount_due'], 2, '.', ''); ?><br/>
                        Due: <?php echo date('m/d/Y', strtotime($v['date_due'])); ?>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Payment Status:</label>
                        <div class="input">
                            <select name="payments[<?php echo $v['payment_number']; ?>][payment_status]" class="span2">
                                <option></option>
                                <option value="Pending"<?php if ($v['payment_status'] == 'Pending') { echo ' selected="selected"'; } ?>>Pending</option>
                                <option value="Received"<?php if ($v['payment_status'] == 'Received') { echo ' selected="selected"'; } ?>>Received</option>
                                <option value="NRF">No Funds</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Payment Received:</label>
                        <div class="input">
                            <input type="text" name="payments[<?php echo $v['payment_number']; ?>][received]" value="<?php if (strlen($v['received'])) { echo date('m/d/Y', strtotime($v['received'])); } ?>" class="span2 datepicker">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Received Amount:</label>
                        <div class="input">
                            <input type="text" name="payments[<?php echo $v['payment_number']; ?>][received_amount]" class="span2 received_amount" value="<?php echo number_format($v['received_amount'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Sales:</label>
                        <div class="input">
                            <select name="payments[<?php echo $v['payment_number']; ?>][commission_to]" class="span2">
                                <option></option>
                                <?php foreach ($users as $u) { ?>
                                <option value="<?php echo $u['id']; ?>"<?php if ($v['commission_to'] == $u['id']) { echo ' selected="selected"'; } ?>><?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Closer:</label>
                        <div class="input">
                            <select name="payments[<?php echo $v['payment_number']; ?>][closer_commission_to]" class="span2">
                                <option></option>
                                <?php foreach ($users as $u) { ?>
                                <option value="<?php echo $u['id']; ?>"<?php if ($v['closer_commission_to'] == $u['id']) { echo ' selected="selected"'; } ?>><?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Sales Percentage:</label>
                        <div class="input">
                            <input id="" type="text" name="payments[<?php echo $v['payment_number']; ?>][commission_percent]" class="span2 commission_percentage" value="<?php echo number_format($v['commission_percent'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Closer Percentage:</label>
                        <div class="input">
                            <input id="" type="text" name="payments[<?php echo $v['payment_number']; ?>][closer_commission_percent]" class="span2 closer_commission_percentage" value="<?php echo number_format($v['closer_commission_percent'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Commission:</label>
                        <div class="input">
                            <input type="text" name="payments[<?php echo $v['payment_number']; ?>][commission_amount]" class="span2 commission_amount" value="<?php echo number_format($v['commission_amount'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Closer Commission:</label>
                        <div class="input">
                            <input type="text" name="payments[<?php echo $v['payment_number']; ?>][closer_commission_amount]" class="span2 closer_commission_amount" value="<?php echo number_format($v['closer_commission_amount'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Pay Date:</label>
                        <div class="input">
                            <input type="text" name="payments[<?php echo $v['payment_number']; ?>][commission_paid]" value="<?php if (strlen($v['commission_paid'])) { echo date('m/d/Y', strtotime($v['commission_paid'])); } ?>" class="span2 datepicker">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Closer Pay Date:</label>
                        <div class="input">
                            <input type="text" name="payments[<?php echo $v['payment_number']; ?>][closer_commission_paid]" value="<?php if (strlen($v['closer_commission_paid'])) { echo date('m/d/Y', strtotime($v['closer_commission_paid'])); } ?>" class="span2 datepicker">
                        </div>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </table>
        <div class="form-actions">
            <input type="submit" value="Save Changes" class="btn btn-primary" style="margin-top:10px;" />
        </div>    
    </fieldset>
    <div class="clear"></div>
</form>
    
</div>
</div>

<?php } ?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".commission_percentage").keyup(function(){
            var percent = $(this).val() / 100;
            var value = $(this).parents('tr').find('input.received_amount').val();
            var total = value*percent;
            total = Math.round(total*Math.pow(10,2))/Math.pow(10,2);
            $(this).parents('tr').find('input.commission_amount').val(total.toFixed(2));
        });
        $(".closer_commission_percentage").keyup(function(){
            var percent = $(this).val() / 100;
            var value = $(this).parents('tr').find('input.received_amount').val();
            var total = value*percent;
            total = Math.round(total*Math.pow(10,2))/Math.pow(10,2);
            $(this).parents('tr').find('input.closer_commission_amount').val(total.toFixed(2));
        });
        $(".received_amount").keyup(function(){
            var percent = $(this).parents('tr').find('input.commission_percentage').val() / 100;
            var closer_percent = $(this).parents('tr').find('input.closer_commission_percentage').val() / 100;
            var value = $(this).val();
            var total = value*percent;
            var closer_total = value*closer_percent;
            total = Math.round(total*Math.pow(10,2))/Math.pow(10,2);
            closer_total = Math.round(closer_total*Math.pow(10,2))/Math.pow(10,2);
            $(this).parents('tr').find('input.commission_amount').val(total.toFixed(2));
            $(this).parents('tr').find('input.closer_commission_amount').val(closer_total.toFixed(2));
        });
    });

    function calc_fees() {
        var total = 0;
        if ($("#eval_fee").val() != '') {
            total = total + parseFloat($("#eval_fee").val());
        }
        if ($("#file_setup_fee").val() != '') {
            total = total + parseFloat($("#file_setup_fee").val());
        }
        if ($("#file_service_fee").val() != '') {
            total = total + parseFloat($("#file_service_fee").val());
        }
        if ($("#settlement_fee").val() != '') {
            total = total + parseFloat($("#settlement_fee").val());
        }
        total = Math.round(total*Math.pow(10,2))/Math.pow(10,2);
        $("#total_fees").val(total.toFixed(2));
    }
</script>