<?php echo View::factory('application/notes', $notes)->render();?>

<div class="row-fluid">
<div class="span9">

<h1>Employment</h1>
<?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>
<div class="clear"></div>    

<form action="/application/employment/<?php echo Uri::segment(3); ?>" method="post" class="form-stacked">
    <fieldset>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Employment</h2>
                    <input type="hidden" name="employment_id" value="<?php echo $employment['id']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Employment Status:</label>
                        <div class="input">
                            <select name="status" class="span4">
                                <option value="W-2 Wage Earner"<?php if ($employment['status'] == 'W-2 Wage Earner') { ?> selected="selected"<?php } ?>>W-2 Wage Earner</option>
                                <option value="1099 Self Employed"<?php if ($employment['status'] == '1099 Self Employed') { ?> selected="selected"<?php } ?>>1099 Self Employed</option>
                                <option value="Both: (W-2 & 1099)"<?php if ($employment['status'] == 'Both: (W-2 & 1099)') { ?> selected="selected"<?php } ?>>Both: (W-2 & 1099)</option>
                                <option value="Unemployed"<?php if ($employment['status'] == 'Unemployed') { ?> selected="selected"<?php } ?>>Unemployed</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Company Name:</label>
                        <div class="input">
                            <input type="text" name="company_name" class="span7" value="<?php echo $employment['company_name']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Position/ Title:</label>
                        <div class="input">
                            <input type="text" name="title" class="span7" value="<?php echo $employment['title']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Job Description:</label>
                        <div class="input">
                            <input type="text" name="job_description" class="span7" value="<?php echo $employment['job_description']; ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Business Owner Info</label>
                    </div>
                    <div class="clearfix">
                        <label>Business Type:</label>
                        <div class="input">
                            <select name="business_type" class="span4">
                                <option value="N/A"<?php if ($employment['business_type'] == 'N/A') { ?> selected="selected"<?php } ?>>N/A</option>
                                <option value="Sole Proprietorship"<?php if ($employment['business_type'] == 'Sole Proprietorship') { ?> selected="selected"<?php } ?>>Sole Proprietorship</option>
                                <option value="Partnership"<?php if ($employment['business_type'] == 'Partnership') { ?> selected="selected"<?php } ?>>Partnership</option>
                                <option value="LLP"<?php if ($employment['business_type'] == 'LLP') { ?> selected="selected"<?php } ?>>LLP</option>
                                <option value="LLC(Single)"<?php if ($employment['business_type'] == 'LLC(Single)') { ?> selected="selected"<?php } ?>>LLC(Single)</option>
                                <option value="LLC(Multiple)"<?php if ($employment['business_type'] == 'LLC(Multiple)') { ?> selected="selected"<?php } ?>>LLC(Multiple)</option>
                                <option value="S Corp"<?php if ($employment['business_type'] == 'S Corp') { ?> selected="selected"<?php } ?>>S Corp</option>
                                <option value="C Corp"<?php if ($employment['business_type'] == 'C Corp') { ?> selected="selected"<?php } ?>>C Corp</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Employer ID:</label>
                        <div class="input">
                            <input type="text" name="employer_id" class="span7" value="<?php echo $employment['employer_id']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Business Taxes:</label>
                        <div class="input">
                            <select name="business_taxes" class="span4">
                                <option value="N/A"<?php if ($employment['business_taxes'] == 'N/A') { ?> selected="selected"<?php } ?>>N/A</option>
                                <option value="From Withholding"<?php if ($employment['business_taxes'] == 'From Withholding') { ?> selected="selected"<?php } ?>>From Withholding</option>
                                <option value="From Profit"<?php if ($employment['business_taxes'] == 'From Profit') { ?> selected="selected"<?php } ?>>From Profit</option>
                            </select>
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