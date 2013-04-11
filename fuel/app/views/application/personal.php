<?php echo View::factory('application/notes', $notes)->render();?>

<div class="row-fluid">
<div class="span9">

<h1>Personal Finances</h1>
<?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>
<div class="clear"></div>    

<form action="/application/personal/<?php echo Uri::segment(3); ?>" method="post" class="form-stacked">
    <fieldset>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Personal Assets</h2>
                    <input type="hidden" name="personal_id" value="<?php echo $personal['personal_id']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Total Cash on Hand:</label>
                        <div class="input">
                            <input type="text" name="asset_cash" class="span3" value="<?php echo number_format($personal['assets']['cash'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Total in Bank Accounts:</label>
                        <div class="input">
                            <input type="text" name="asset_total_bank_accounts" class="span3" value="<?php echo number_format($personal['assets']['total_bank_accounts'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Total Investments:</label>
                        <div class="input">
                            <input type="text" name="asset_total_investments" class="span3" value="<?php echo number_format($personal['assets']['total_investments'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Life Insurance:</label>
                        <div class="input">
                            <input type="text" name="asset_life_insurance" class="span3" value="<?php echo number_format($personal['assets']['life_insurance'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Total in Retirement Accounts:</label>
                        <div class="input">
                            <input type="text" name="asset_retirement_accounts" class="span3" value="<?php echo number_format($personal['assets']['retirement_accounts'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Total Real Estate:</label>
                        <div class="input">
                            <input type="text" name="asset_real_estate" class="span3" value="<?php echo number_format($personal['assets']['real_estate'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>First Vehicle:</label>
                        <div class="input">
                            <input type="text" name="asset_vehicle_1" class="span3" value="<?php echo number_format($personal['assets']['vehicle_1'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Second Vehicle:</label>
                        <div class="input">
                            <input type="text" name="asset_vehicle_2" class="span3" value="<?php echo number_format($personal['assets']['vehicle_2'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Personal Effects:</label>
                        <div class="input">
                            <input type="text" name="asset_personal_effects" class="span3" value="<?php echo number_format($personal['assets']['personal_effects'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Other Assets:</label>
                        <div class="input">
                            <input type="text" name="asset_other_assets" class="span3" value="<?php echo number_format($personal['assets']['other_assets'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Personal Income</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Total Wages:</label>
                        <div class="input">
                            <input type="text" name="inc_wages" class="span3" value="<?php echo number_format($personal['income']['wages'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Social Security Income:</label>
                        <div class="input">
                            <input type="text" name="inc_social_security" class="span3" value="<?php echo number_format($personal['income']['social_security'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Total Spouse Income:</label>
                        <div class="input">
                            <input type="text" name="inc_co_income" class="span3" value="<?php echo number_format($personal['income']['co_income'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Social Security Income (Spouse):</label>
                        <div class="input">
                            <input type="text" name="inc_co_social_security" class="span3" value="<?php echo number_format($personal['income']['co_social_security'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Contribution Income:</label>
                        <div class="input">
                            <input type="text" name="inc_contributions" class="span3" value="<?php echo number_format($personal['income']['contributions'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Dividends / Interest:</label>
                        <div class="input">
                            <input type="text" name="inc_dividends_interest" class="span3" value="<?php echo number_format($personal['income']['dividends_interest'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Rental Income:</label>
                        <div class="input">
                            <input type="text" name="inc_rental" class="span3" value="<?php echo number_format($personal['income']['rental'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Distributions (K-1):</label>
                        <div class="input">
                            <input type="text" name="inc_distributions" class="span3" value="<?php echo number_format($personal['income']['distributions'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Alimony:</label>
                        <div class="input">
                            <input type="text" name="inc_alimony" class="span3" value="<?php echo number_format($personal['income']['alimony'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Child Support:</label>
                        <div class="input">
                            <input type="text" name="inc_child_support" class="span3" value="<?php echo number_format($personal['income']['child_support'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Other Income (Rent Subsidy, Oil Credit, Etc.):</label>
                        <div class="input">
                            <input type="text" name="inc_other_1" class="span3" value="<?php echo number_format($personal['income']['other_1'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Other Income:</label>
                        <div class="input">
                            <input type="text" name="inc_other_2" class="span3" value="<?php echo number_format($personal['income']['other_2'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Other Income:</label>
                        <div class="input">
                            <input type="text" name="inc_other_3" class="span3" value="<?php echo number_format($personal['income']['other_3'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Other Income:</label>
                        <div class="input">
                            <input type="text" name="inc_other_4" class="span3" value="<?php echo number_format($personal['income']['other_4'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Personal Expenses</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Persons Under 65:</label>
                        <div class="input">
                            <input type="text" name="exp_persons_under_65" class="span2" value="<?php echo $personal['expenses']['persons_under_65']; ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Persons Over 65:</label>
                        <div class="input">
                            <input type="text" name="exp_persons_over_65" class="span2" value="<?php echo $personal['expenses']['persons_over_65']; ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Food:</label>
                        <div class="input">
                            <input type="text" name="exp_food" class="span3" value="<?php echo number_format($personal['expenses']['food'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Housekeeping Supplies:</label>
                        <div class="input">
                            <input type="text" name="exp_housekeeping_supplies" class="span3" value="<?php echo number_format($personal['expenses']['housekeeping_supplies'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Apparel:</label>
                        <div class="input">
                            <input type="text" name="exp_apparel" class="span3" value="<?php echo number_format($personal['expenses']['apparel'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Personal Care:</label>
                        <div class="input">
                            <input type="text" name="exp_personal_care" class="span3" value="<?php echo number_format($personal['expenses']['personal_care'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Miscellaneous:</label>
                        <div class="input">
                            <input type="text" name="exp_misc" class="span3" value="<?php echo number_format($personal['expenses']['misc'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>First Lien Mortgage:</label>
                        <div class="input">
                            <input type="text" name="exp_first_lien_mortgage" class="span3" value="<?php echo number_format($personal['expenses']['first_lien_mortgage'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Second Lien Mortgage:</label>
                        <div class="input">
                            <input type="text" name="exp_second_lien_mortgage" class="span3" value="<?php echo number_format($personal['expenses']['second_lien_mortgage'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Property Taxes:</label>
                        <div class="input">
                            <input type="text" name="exp_property_tax" class="span3" value="<?php echo number_format($personal['expenses']['property_tax'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Homeowners Insurance:</label>
                        <div class="input">
                            <input type="text" name="exp_homeowners_insurance" class="span3" value="<?php echo number_format($personal['expenses']['homeowners_insurance'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Rent:</label>
                        <div class="input">
                            <input type="text" name="exp_rent" class="span3" value="<?php echo number_format($personal['expenses']['rent'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Gas:</label>
                        <div class="input">
                            <input type="text" name="exp_gas" class="span3" value="<?php echo number_format($personal['expenses']['gas'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Electric:</label>
                        <div class="input">
                            <input type="text" name="exp_electric" class="span3" value="<?php echo number_format($personal['expenses']['electric'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Water:</label>
                        <div class="input">
                            <input type="text" name="exp_water" class="span3" value="<?php echo number_format($personal['expenses']['water'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Sewer:</label>
                        <div class="input">
                            <input type="text" name="exp_sewer" class="span3" value="<?php echo number_format($personal['expenses']['sewer'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Cable:</label>
                        <div class="input">
                            <input type="text" name="exp_cable" class="span3" value="<?php echo number_format($personal['expenses']['cable'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Trash:</label>
                        <div class="input">
                            <input type="text" name="exp_trash" class="span3" value="<?php echo number_format($personal['expenses']['trash'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Phone:</label>
                        <div class="input">
                            <input type="text" name="exp_phone" class="span3" value="<?php echo number_format($personal['expenses']['phone'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Public Transportation:</label>
                        <div class="input">
                            <input type="text" name="exp_public_transportation" class="span3" value="<?php echo number_format($personal['expenses']['public_transportation'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>First Auto Payment:</label>
                        <div class="input">
                            <input type="text" name="exp_first_auto_payment" class="span3" value="<?php echo number_format($personal['expenses']['first_auto_payment'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Second Auto Payment:</label>
                        <div class="input">
                            <input type="text" name="exp_second_auto_payment" class="span3" value="<?php echo number_format($personal['expenses']['second_auto_payment'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Auto Insurance:</label>
                        <div class="input">
                            <input type="text" name="exp_auto_insurance" class="span3" value="<?php echo number_format($personal['expenses']['auto_insurance'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Auto Fuel Expenses:</label>
                        <div class="input">
                            <input type="text" name="exp_auto_fuel" class="span3" value="<?php echo number_format($personal['expenses']['auto_fuel'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Health Insurance:</label>
                        <div class="input">
                            <input type="text" name="exp_health_insurance" class="span3" value="<?php echo number_format($personal['expenses']['health_insurance'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Prescriptions:</label>
                        <div class="input">
                            <input type="text" name="exp_prescriptions" class="span3" value="<?php echo number_format($personal['expenses']['prescriptions'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Copays:</label>
                        <div class="input">
                            <input type="text" name="exp_copays" class="span3" value="<?php echo number_format($personal['expenses']['copays'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Whole Life Insurance:</label>
                        <div class="input">
                            <input type="text" name="exp_whole_life_insurance" class="span3" value="<?php echo number_format($personal['expenses']['whole_life_insurance'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Term Life Insurance:</label>
                        <div class="input">
                            <input type="text" name="exp_Term_life_insurance" class="span3" value="<?php echo number_format($personal['expenses']['term_life_insurance'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Court Ordered Payments:</label>
                        <div class="input">
                            <input type="text" name="exp_court_ordered_payments" class="span3" value="<?php echo number_format($personal['expenses']['court_ordered_payments'], 2, '.', ''); ?>">
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