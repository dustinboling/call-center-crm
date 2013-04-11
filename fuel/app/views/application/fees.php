<?php echo View::factory('application/notes', $notes)->render();?>

<div class="row-fluid">
<div class="span9">

<h1>Customer Fees Schedule</h1>
<?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>
<div class="clear"></div>    
    
<form action="/application/fees/<?php echo Uri::segment(3); ?>" method="post" class="form-stacked">
    <fieldset>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Pinnacle Fees</h2>
                    <input type="hidden" name="tax_problem_id" value="<?php echo $fees['tax_problem_id'] ?>" />
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Evaluation Fees:</label>
                        <div class="input">
                            <input type="text" id="eval_fee" name="service_eval_fee" class="span3" value="<?php echo number_format($fees['eval_fee'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>File Setup Fee:</label>
                        <div class="input">
                            <input type="text" id="file_setup_fee" name="service_file_setup_fee" class="span3" value="<?php echo number_format($fees['file_setup_fee'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>File Service Fee:</label>
                        <div class="input">
                            <input type="text" id="file_service_fee" name="service_file_service_fee" class="span3" value="<?php echo number_format($fees['file_service_fee'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Settlement Fee:</label>
                        <div class="input">
                            <input type="text" id="settlement_fee" name="service_settlement_fee" class="span3" value="<?php echo number_format($fees['settlement_fee'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="clearfix">
                        <label>Total Fees:</label>
                        <div class="input">
                            <input type="text" id="total_fees" name="total_fees" class="span3" value="0">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="<?php if (empty($payments)) { echo '3'; } else { echo '4'; } ?>">
                    <h2>Payments</h2>
                </td>
            </tr>
            <?php if (empty($payments)) { ?>
            <?php for ($i=1; $i<13; $i++) { ?>
            <?php
                if ($i == 1) {
                    $date = date('m/d/Y', time());
                } else {
                    $d = $i-1;
                    $v = "+$d months";
                    $date = date('m/d/Y', strtotime($v, time()));
                }
            ?>
            <tr>
                <td>
                    <div class="clearfix">
                        <label>Payment <?php echo $i; ?></label>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Payment Due:</label>
                        <div class="input">
                            <input type="text" name="payments[<?php echo $i; ?>][date_due]" value="<?php echo $date; ?>" class="span4 datepicker">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Payment Amount:</label>
                        <div class="input">
                            <input type="text" name="payments[<?php echo $i; ?>][amount_due]" class="span3 payment_amount">
                        </div>
                    </div>
                </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <?php foreach ($payments as $v) { ?>
            <tr>
                <td>
                    <div class="clearfix">
                        <label>Payment <?php echo $v['payment_number']; ?></label>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Payment Due:</label>
                        <div class="input">
                            <input type="text" name="payments[<?php echo $v['payment_number']; ?>][date_due]" value="<?php echo date('m/d/Y', strtotime($v['date_due'])); ?>" class="span4 datepicker">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Payment Amount:</label>
                        <div class="input">
                            <input type="text" name="payments[<?php echo $v['payment_number']; ?>][amount_due]" class="span3 payment_amount" value="<?php echo number_format($v['amount_due'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Payment Received:</label>
                        <?php if (strlen($v['received'])) {
                            echo 'Received: '.date('m/d/Y', strtotime($v['received']));
                        } else {
                            echo 'Not Received';
                        } ?>
                    </div>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
            <tr>
                <td colspan="<?php if (empty($payments)) { echo '3'; } else { echo '4'; } ?>">
                    <h2>Total Payments: $<span id="total_payments"></span></h2>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <input type="submit" value="Save Changes" class="btn btn-primary" style="margin-top:10px;" />
        </div>
    </fieldset>
    <div class="clear"></div>
</form>

</div>
</div>    
    
<script type="text/javascript">
    $(document).ready(function(){
        $(function(){
            calc_fees();
            calc_payments();
        });
        $("#eval_fee").keyup(function(){
            calc_fees();
        });

        $("#file_setup_fee").keyup(function(){
            calc_fees();
        });

        $("#file_service_fee").keyup(function(){
            calc_fees();
        });

        $("#settlement_fee").keyup(function(){
            calc_fees();
        });

        $("#eval_fee").focus(function(){
            if ($("#eval_fee").val() == '0.00') {
                $("#eval_fee").val('');
            }
        });

        $("#eval_fee").blur(function(){
            if ($("#eval_fee").val() == '') {
                $("#eval_fee").val('0.00');
            }
        });

        $("#file_setup_fee").focus(function(){
            if ($("#file_setup_fee").val() == '0.00') {
                $("#file_setup_fee").val('');
            }
        });

        $("#file_setup_fee").blur(function(){
            if ($("#file_setup_fee").val() == '') {
                $("#file_setup_fee").val('0.00');
            }
        });

        $("#file_service_fee").focus(function(){
            if ($("#file_service_fee").val() == '0.00') {
                $("#file_service_fee").val('');
            }
        });

        $("#file_service_fee").blur(function(){
            if ($("#file_service_fee").val() == '') {
                $("#file_service_fee").val('0.00');
            }
        });

        $("#settlement_fee").focus(function(){
            if ($("#settlement_fee").val() == '0.00') {
                $("#settlement_fee").val('');
            }
        });

        $("#settlement_fee").blur(function(){
            if ($("#settlement_fee").val() == '') {
                $("#settlement_fee").val('0.00');
            }
        });
        $(".payment_amount").change(function(){
            calc_payments();
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

    function calc_payments() {
        var total = 0;
        $(".payment_amount").each(function(){
            if ($(this).val() != '') {
                total = total + parseFloat($(this).val());
            }
        });
        total = Math.round(total*Math.pow(10,2))/Math.pow(10,2);
        $("#total_payments").html(total.toFixed(2));
    }
</script>