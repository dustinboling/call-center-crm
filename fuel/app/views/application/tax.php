<?php echo View::factory('application/notes', $notes)->render();?>

<style> .highlight { background-color: #ffff99 } </style>

<div class="row-fluid">
<div class="span9">
    
<h1>Current Tax Information</h1>
<?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>
<div class="clear"></div>    

<form action="/application/tax/<?php echo Uri::segment(3); ?>" method="post" class="form-stacked">
    <fieldset>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Tax Problem</h2>
                    <input type="hidden" name="tax_problem_id" value="<?php echo $tax_problem['tax_problem_id']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Tax Type:</label>
                        <div class="input">
                            <select name="tax_type" class="span4">
                                <option value="Personal"<?php if ($tax_problem['tax_type'] == 'Personal') { ?> selected="selected"<?php } ?>>Personal</option>
                                <option value="Business"<?php if ($tax_problem['tax_type'] == 'Business') { ?> selected="selected"<?php } ?>>Business</option>
                                <option value="Personal and Business"<?php if ($tax_problem['tax_type'] == 'Personal and Business') { ?> selected="selected"<?php } ?>>Personal and Business</option>
                                <option value="Payroll"<?php if ($tax_problem['tax_type'] == 'Payroll') { ?> selected="selected"<?php } ?>>Payroll</option>
                                <option value="Other"<?php if ($tax_problem['tax_type'] == 'Other') { ?> selected="selected"<?php } ?>>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Tax Agency:</label>
                        <div class="input">
                            <select name="tax_agency" class="span3">
                                <option value="Both"<?php if ($tax_problem['tax_agency'] == 'Both') { ?> selected="selected"<?php } ?>>Both</option>
                                <option value="Federal"<?php if ($tax_problem['tax_agency'] == 'Federal') { ?> selected="selected"<?php } ?>>Federal</option>
                                <option value="State"<?php if ($tax_problem['tax_agency'] == 'State') { ?> selected="selected"<?php } ?>>State</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Tax Liability</label>
                        <div class="input">
                            <input type="text" name="tax_liability" class="span3" value="<?php echo number_format($tax_problem['tax_liability'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Tax Problem:</label>
                        <div class="input">
                            <select name="tax_problem" class="span4">
                                <option value="Assets Seized"<?php if ($tax_problem['tax_problem'] == 'Assets Seized') { ?> selected="selected"<?php } ?>>Assets Seized</option>
                                <option value="Bank Account Levy"<?php if ($tax_problem['tax_problem'] == 'Bank Account Levy') { ?> selected="selected"<?php } ?>>Bank Account Levy</option>
                                <option value="Can't Pay Unpaid Taxes"<?php if ($tax_problem['tax_problem'] == "Can't Pay Unpaid Taxes") { ?> selected="selected"<?php } ?>>Can't Pay Unpaid Taxes</option>
                                <option value="Innocent Spouse"<?php if ($tax_problem['tax_problem'] == 'Innocent Spouse') { ?> selected="selected"<?php } ?>>Innocent Spouse</option>
                                <option value="Lien Filed"<?php if ($tax_problem['tax_problem'] == 'Lien Filed') { ?> selected="selected"<?php } ?>>Lien Filed</option>
                                <option value="Received Audit Notice"<?php if ($tax_problem['tax_problem'] == 'Received Audit Notice') { ?> selected="selected"<?php } ?>>Received Audit Notice</option>
                                <option value="Unfiled Tax Returns"<?php if ($tax_problem['tax_problem'] == 'Unfiled Tax Returns') { ?> selected="selected"<?php } ?>>Unfiled Tax Returns</option>
                                <option value="Unpaid Penalties and Interest"<?php if ($tax_problem['tax_problem'] == 'Unpaid Penalties and Interest') { ?> selected="selected"<?php } ?>>Unpaid Penalties and Interest</option>
                                <option value="Wage Garnishment"<?php if ($tax_problem['tax_problem'] == 'Wage Garnishment') { ?> selected="selected"<?php } ?>>Wage Garnishment</option>
                                <option value="Other"<?php if ($tax_problem['tax_problem'] == 'Other') { ?> selected="selected"<?php } ?>>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Form Numbers:</label>
                        <div class="input">
                            <select name="tax_forms" class="span3">
                                <option value="N/A"<?php if ($tax_problem['tax_forms'] == 'N/A') { ?> selected="selected"<?php } ?>>N/A</option>
                                <option value="Federal 1040"<?php if ($tax_problem['tax_forms'] == 'Federal 1040') { ?> selected="selected"<?php } ?>>Federal 1040</option>
                                <option value="Civil Penalty"<?php if ($tax_problem['tax_forms'] == 'Civil Penalty') { ?> selected="selected"<?php } ?>>Civil Penalty</option>
                                <option value="Federal 1120"<?php if ($tax_problem['tax_forms'] == 'Federal 1120') { ?> selected="selected"<?php } ?>>Federal 1120</option>
                                <option value="Federal 940/941"<?php if ($tax_problem['tax_forms'] == 'Federal 940/941') { ?> selected="selected"<?php } ?>>Federal 940/941</option>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Description of Tax Problem:</label>
                        <div class="input">
                            <textarea name="tax_problem_description" class="span7"><?php echo $tax_problem['tax_problem_description']; ?></textarea>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Description of Hardship:</label>
                        <div class="input">
                            <textarea name="tax_hardship_description" class="span7"><?php echo $tax_problem['tax_hardship_description']; ?></textarea>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>IRS Letter</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Did you receive a letter in the mail?</label>
                        <div class="input">
                            <select name="irs_letter_received" class="span3">
                                <option value="0"<?php if (!$tax_problem['irs_letter_received']) { ?> selected="selected"<?php } ?>>No</option>
                                <option value="1"<?php if ($tax_problem['irs_letter_received']) { ?> selected="selected"<?php } ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Is there any mention of a lien?</label>
                        <div class="input">
                            <select name="lien_mention" class="span3">
                                <option value="0"<?php if (!$tax_problem['lien_mention']) { ?> selected="selected"<?php } ?>>No</option>
                                <option value="1"<?php if ($tax_problem['lien_mention']) { ?> selected="selected"<?php } ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>How did you receive this letter? Was it Certified?</label>
                        <div class="input">
                            <select name="certified_mail" class="span3">
                                <option value="0"<?php if (!$tax_problem['certified_mail']) { ?> selected="selected"<?php } ?>>No</option>
                                <option value="1"<?php if ($tax_problem['certified_mail']) { ?> selected="selected"<?php } ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>What exactly did the letter say?</label>
                        <div class="input">
                            <textarea name="letter_description" class="span7"><?php echo $tax_problem['letter_description']; ?></textarea>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Current Status</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Are you currently in a payment plan with the IRS?</label>
                        <div class="input">
                            <select name="in_fed_payment_plan" class="span3">
                                <option value="0"<?php if (!$tax_problem['in_fed_payment_plan']) { ?> selected="selected"<?php } ?>>No</option>
                                <option value="1"<?php if ($tax_problem['in_fed_payment_plan']) { ?> selected="selected"<?php } ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>How much is your monthly payment?</label>
                        <div class="input">
                            <input type="text" name="fed_monthly_payment" class="span3" value="<?php if ($tax_problem['fed_monthly_payment']) { echo number_format($tax_problem['fed_monthly_payment'], 2, '.', ''); } ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>When did the plan start?</label>
                        <div class="input">
                            <input type="text" name="fed_date_plan_started" class="span3 datepicker" value="<?php if (strlen($tax_problem['fed_date_plan_started'])) { echo date('m/d/Y', strtotime($tax_problem['fed_date_plan_started'])); } ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Are you currently in a payment plan with the State?</label>
                        <div class="input">
                            <select name="in_state_payment_plan" class="span3">
                                <option value="0"<?php if (!$tax_problem['in_state_payment_plan']) { ?> selected="selected"<?php } ?>>No</option>
                                <option value="1"<?php if ($tax_problem['in_state_payment_plan']) { ?> selected="selected"<?php } ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>How much is your monthly payment?</label>
                        <div class="input">
                            <input type="text" name="state_monthly_payment" class="span3" value="<?php if ($tax_problem['state_monthly_payment']) { echo number_format($tax_problem['state_monthly_payment'], 2, '.', ''); } ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>When did the plan start?</label>
                        <div class="input">
                            <input type="text" name="state_date_plan_started" class="span3 datepicker" value="<?php if (strlen($tax_problem['state_date_plan_started'])) { echo date('m/d/Y', strtotime($tax_problem['state_date_plan_started'])); } ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="clearfix">
                        <label>Are you currently in Bankruptcy?</label>
                        <div class="input">
                            <select name="in_bankruptcy" class="span3">
                                <option value="0"<?php if (!$tax_problem['in_bankruptcy']) { ?> selected="selected"<?php } ?>>No</option>
                                <option value="1"<?php if ($tax_problem['in_bankruptcy']) { ?> selected="selected"<?php } ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>(If Yes Above) What is the discharge date?</label>
                        <div class="input">
                            <input type="text" name="bankruptcy_discharge_date" class="span3 datepicker" value="<?php if (strlen($tax_problem['bankruptcy_discharge_date'])) { echo date('m/d/Y', strtotime($tax_problem['bankruptcy_discharge_date'])); } ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Last Status Date From IRSlogics:</label>
                        <div class="input">
                            <input type="text" name="last_status_irslogics" class="span3 datepicker" value="<?php if (strlen($tax_problem['last_status_irslogics'])) { echo date('m/d/Y', strtotime($tax_problem['last_status_irslogics'])); } ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Date Closed By Compliance:</label>
                        <div class="input">
                            <input type="text" name="compliance_closed_date" class="span3 datepicker" value="<?php if (strlen($tax_problem['compliance_closed_date'])) { echo date('m/d/Y', strtotime($tax_problem['compliance_closed_date'])); } ?>">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
<?php
if (isset($tax_problem['created']) && !is_null($tax_problem['created'])) {
    $start_year = (date('Y', strtotime($tax_problem['created']))) - 1;
} else {
    $start_year = (date('Y')) - 1;
}
$end_year = $start_year - 10;
?>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="5">
                    <h2>Tax Activity</h2>
                </td>
            </tr>
            <tr>
                <td><strong>Year</strong></td>
                <td><strong>Federal Activity</strong></td>
                <td><strong>Federal Owed</strong></td>
                <td><strong>State Activity</strong></td>
                <td><strong>State Owed</strong></td>
            </tr>
            <?php for($i = $start_year; $i >= $end_year; $i--) { ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td>
                    <?php if (isset($tax_activity['federal'][$i]) && $tax_activity['federal'][$i]['not_filed']) { ?>
                    <select name="tax_activity[federal][<?php echo $i; ?>][not_filed]" class="span2 highlight">
                        <option value="1" selected="selected">Not Filed</option>
                        <option value="0">Filed</option>
                    </select>
                    <?php } else { ?>
                    <select name="tax_activity[federal][<?php echo $i; ?>][not_filed]" class="span2">
                        <option value="1">Not Filed</option>
                        <option value="0" selected="selected">Filed</option>
                    </select>
                    <?php } ?>
                </td>
                <td>
                    <?php if (isset($tax_activity['federal'][$i]) && $tax_activity['federal'][$i]['owed']) { ?>
                    <select name="tax_activity[federal][<?php echo $i; ?>][owed]" class="span2 highlight">
                        <option value="1" selected="selected">Owed</option>
                        <option value="0">Not Owed</option>
                    </select>
                    <?php } else { ?>
                    <select name="tax_activity[federal][<?php echo $i; ?>][owed]" class="span2">
                        <option value="1">Owed</option>
                        <option value="0" selected="selected">Not Owed</option>
                    </select>
                    <?php } ?>
                </td>
                <td>
                    <?php if (isset($tax_activity['state'][$i]) && $tax_activity['state'][$i]['not_filed']) { ?>
                    <select name="tax_activity[state][<?php echo $i; ?>][not_filed]" class="span2 highlight">
                        <option value="1" selected="selected">Not Filed</option>
                        <option value="0">Filed</option>
                    </select>
                    <?php } else { ?>
                    <select name="tax_activity[state][<?php echo $i; ?>][not_filed]" class="span2">
                        <option value="1">Not Filed</option>
                        <option value="0" selected="selected">Filed</option>
                    </select>
                    <?php } ?>
                </td>
                <td>
                    <?php if (isset($tax_activity['state'][$i]) && $tax_activity['state'][$i]['owed']) { ?>
                    <select name="tax_activity[state][<?php echo $i; ?>][owed]" class="span2 highlight">
                        <option value="1" selected="selected">Owed</option>
                        <option value="0">Not Owed</option>
                    </select>
                    <?php } else { ?>
                    <select name="tax_activity[state][<?php echo $i; ?>][owed]" class="span2">
                        <option value="1">Owed</option>
                        <option value="0" selected="selected">Not Owed</option>
                    </select>
                    <?php } ?>
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