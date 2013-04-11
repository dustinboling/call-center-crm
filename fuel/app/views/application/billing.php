<?php echo View::factory('application/notes', $notes)->render();?>

<div class="row-fluid">
<div class="span9">

<h1>Customer Billing Information</h1>
<?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>
<div class="clear"></div>    

<form action="/application/billing/<?php echo Uri::segment(3); ?>" method="post" class="form-stacked">
    <fieldset>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Bank Account Information</h2>
                    <input type="hidden" name="user_id" value="<?php echo $billing['user_id']; ?>" />
                    <input type="hidden" id="profile_address" value="<?php echo $billing['profile_address']; ?>" />
                    <input type="hidden" id="profile_city" value="<?php echo $billing['profile_city']; ?>" />
                    <input type="hidden" id="profile_state" value="<?php echo $billing['profile_state']; ?>" />
                    <input type="hidden" id="profile_zip" value="<?php echo $billing['profile_zip']; ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="clearfix">
                        <label>Bank Name:</label>
                        <div class="input">
                            <input type="text" name="bank_name" class="span7" value="<?php echo $billing['bank']['name']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Bank Branch:</label>
                        <div class="input">
                            <input type="text" name="bank_branch" class="span7" value="<?php echo $billing['bank']['branch']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Bank Routing Number:</label>
                        <div class="input">
                            <input type="text" name="bank_routing_number" class="span7" value="<?php echo $billing['bank']['routing_number']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Bank Account Number:</label>
                        <div class="input">
                            <input type="text" name="bank_account_number" class="span7" value="<?php echo $billing['bank']['account_number']; ?>">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Credit Card Information</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Name on Credit Card:</label>
                        <div class="input">
                            <input type="text" name="cc_name" class="span7" value="<?php echo $billing['credit_card']['name']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Credit Card Type:</label>
                        <div class="input">
                            <select name="cc_card_type" class="span3">
                                <option value="Visa"<?php if ($billing['credit_card']['card_type'] == 'Visa') { ?> selected="selected"<?php } ?>>Visa</option>
                                <option value="Master Card"<?php if ($billing['credit_card']['card_type'] == 'Master Card') { ?> selected="selected"<?php } ?>>Master Card</option>
                                <option value="American Express"<?php if ($billing['credit_card']['card_type'] == 'American Express') { ?> selected="selected"<?php } ?>>American Express</option>
                                <option value="Discover"<?php if ($billing['credit_card']['card_type'] == 'Discover') { ?> selected="selected"<?php } ?>>Discover</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Credit Card Number:</label>
                        <div class="input">
                            <input type="text" name="cc_number" class="span7" value="<?php echo $billing['credit_card']['number']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Credit Card Expiration:</label>
                        <div class="input">
                            <input type="text" name="cc_exp_date" class="span3" value="<?php echo $billing['credit_card']['exp_date']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Security Code on back of Credit Card:</label>
                        <div class="input">
                            <input type="text" name="cc_cvv" class="span3" value="<?php echo $billing['credit_card']['cvv']; ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Billing Address on Credit Card (<span style="color:#990000">very important!</span>):</label>
                        <div class="input">
                            <input type="text" id="cc_billing_address" name="cc_billing_address" class="span7" value="<?php echo $billing['credit_card']['billing_address']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="input">
                            <div class="inline-inputs">
                                <label>City, State Zip:</label>
                                <input type="text" id="cc_billing_city" name="cc_billing_city" class="span4" value="<?php echo $billing['credit_card']['billing_city']; ?>">
                                <select id="cc_billing_state" name="cc_billing_state" class="span2">
                                    <?php echo \formselect::states_option($billing['credit_card']['billing_state']); ?>
                                </select>
                                <input type="text" id="cc_billing_zip" name="cc_billing_zip" class="span2" value="<?php echo $billing['credit_card']['billing_zip']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Same as Mailing?</label>
                        <div class="input">
                            <input type="checkbox" id="cc_same_as_mailing" name="cc_same_as_mailing" value="1" <?php if ($billing['credit_card']['same_as_mailing']) { echo ' checked="checked"'; } ?>/>
                        </div>
                    </div>
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
    $("#cc_same_as_mailing").click(function(e) {
        $("#cc_billing_state").val($("#profile_state").val());
        if ($('#cc_same_as_mailing').is(':checked')) {
            $("#cc_billing_address").val($("#profile_address").val());
            $("#cc_billing_city").val($("#profile_city").val());
            $("#cc_billing_zip").val($("#profile_zip").val());
        } else {
            $("#cc_billing_address").val('');
            $("#cc_billing_city").val('');
            $("#cc_billing_zip").val('');
        }
    });
    $("#cc_billing_address").change(function(){
        $('#cc_same_as_mailing').removeAttr('checked');
    });
    $("#cc_billing_city").change(function(){
        $('#cc_same_as_mailing').removeAttr('checked');
    });
    $("#cc_billing_state").change(function(){
        $('#cc_same_as_mailing').removeAttr('checked');
    });
    $("#cc_billing_zip").change(function(){
        $('#cc_same_as_mailing').removeAttr('checked');
    });
</script>