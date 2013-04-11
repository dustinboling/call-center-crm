<?php echo View::factory('application/notes', $notes)->render();?>

<div class="row-fluid">
<div class="span9">

<h1>Business Owner Finances</h1>
<?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>
<div class="clear"></div>    
    
<form action="/application/business/<?php echo Uri::segment(3); ?>" method="post" class="form-stacked">
    <fieldset>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Business Assets</h2>
                    <input type="hidden" name="business_id" value="<?php echo $business['business_id']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Total Cash on Hand:</label>
                        <div class="input">
                            <input type="text" name="asset_cash" class="span3" value="<?php echo number_format($business['assets']['cash'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Total in Bank Accounts:</label>
                        <div class="input">
                            <input type="text" name="asset_total_bank_accounts" class="span3" value="<?php echo number_format($business['assets']['total_bank_accounts'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Receivables:</label>
                        <div class="input">
                            <input type="text" name="asset_receivables" class="span3" value="<?php echo number_format($business['assets']['receivables'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Total Property:</label>
                        <div class="input">
                            <input type="text" name="asset_property" class="span3" value="<?php echo number_format($business['assets']['property'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Tools and Books:</label>
                        <div class="input">
                            <input type="text" name="asset_tools_books" class="span3" value="<?php echo number_format($business['assets']['tools_books'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Other Assets:</label>
                        <div class="input">
                            <input type="text" name="asset_other_assets" class="span3" value="<?php echo number_format($business['assets']['other_assets'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Business Income</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Gross Receipts:</label>
                        <div class="input">
                            <input type="text" name="inc_gross_receipts" class="span3" value="<?php echo number_format($business['income']['gross_receipts'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Rental:</label>
                        <div class="input">
                            <input type="text" name="inc_rental" class="span3" value="<?php echo number_format($business['income']['rental'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Interest:</label>
                        <div class="input">
                            <input type="text" name="inc_interest" class="span3" value="<?php echo number_format($business['income']['interest'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Dividends:</label>
                        <div class="input">
                            <input type="text" name="inc_dividends" class="span3" value="<?php echo number_format($business['income']['dividends'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Cash Income:</label>
                        <div class="input">
                            <input type="text" name="inc_cash" class="span3" value="<?php echo number_format($business['income']['cash'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Other Income:</label>
                        <div class="input">
                            <input type="text" name="inc_other_1" class="span3" value="<?php echo number_format($business['income']['other_1'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Other Income:</label>
                        <div class="input">
                            <input type="text" name="inc_other_2" class="span3" value="<?php echo number_format($business['income']['other_2'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Other Income:</label>
                        <div class="input">
                            <input type="text" name="inc_other_3" class="span3" value="<?php echo number_format($business['income']['other_3'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Other Income:</label>
                        <div class="input">
                            <input type="text" name="inc_other_4" class="span3" value="<?php echo number_format($business['income']['other_4'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Business Expenses</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Materials:</label>
                        <div class="input">
                            <input type="text" name="exp_materials" class="span3" value="<?php echo number_format($business['expenses']['materials'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Supplies:</label>
                        <div class="input">
                            <input type="text" name="exp_supplies" class="span3" value="<?php echo number_format($business['expenses']['supplies'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Inventory:</label>
                        <div class="input">
                            <input type="text" name="exp_inventory" class="span3" value="<?php echo number_format($business['expenses']['inventory'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Gross Wages Salaries:</label>
                        <div class="input">
                            <input type="text" name="exp_gross_wages_salaries" class="span3" value="<?php echo number_format($business['expenses']['gross_wages_salaries'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Rent:</label>
                        <div class="input">
                            <input type="text" name="exp_rent" class="span3" value="<?php echo number_format($business['expenses']['rent'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Utilities:</label>
                        <div class="input">
                            <input type="text" name="exp_utilities" class="span3" value="<?php echo number_format($business['expenses']['utilities'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Gas &amp; Oil:</label>
                        <div class="input">
                            <input type="text" name="exp_gas_oil" class="span3" value="<?php echo number_format($business['expenses']['gas_oil'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Maintenance:</label>
                        <div class="input">
                            <input type="text" name="exp_maintenance" class="span3" value="<?php echo number_format($business['expenses']['maintenance'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Taxes:</label>
                        <div class="input">
                            <input type="text" name="exp_taxes" class="span3" value="<?php echo number_format($business['expenses']['taxes'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Other Expenses:</label>
                        <div class="input">
                            <input type="text" name="exp_other_1" class="span3" value="<?php echo number_format($business['expenses']['other_1'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Other Expenses:</label>
                        <div class="input">
                            <input type="text" name="exp_other_2" class="span3" value="<?php echo number_format($business['expenses']['other_2'], 2, '.', ''); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Other Expenses:</label>
                        <div class="input">
                            <input type="text" name="exp_other_3" class="span3" value="<?php echo number_format($business['expenses']['other_3'], 2, '.', ''); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Other Expenses:</label>
                        <div class="input">
                            <input type="text" name="exp_other_4" class="span3" value="<?php echo number_format($business['expenses']['other_4'], 2, '.', ''); ?>">
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