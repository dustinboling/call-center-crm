<?php echo View::factory('application/notes', $notes)->render();?>

<div class="row-fluid">
<div class="span9">
    
<h1>Customer Profile</h1>
<?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>
<div class="clear"></div>    

<form action="/application/profile/<?php echo Uri::segment(3); ?>" method="post" class="form-stacked">
    <fieldset>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Client Information</h2>
                    <input type="hidden" name="user_id" value="<?php echo $profile['user_id']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>First Name:</label>
                        <div class="input">
                            <input type="text" name="first_name" class="span7" value="<?php echo $profile['first_name']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Middle Name:</label>
                        <div class="input">
                            <input type="text" name="middle_name" class="span7" value="<?php echo $profile['middle_name']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Last Name:</label>
                        <div class="input">
                            <input type="text" name="last_name" class="span7" value="<?php echo $profile['last_name']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Email Address:</label>
                        <div class="input">
                            <input type="text" name="email" class="span7" value="<?php echo $profile['email']; ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Primary Address:</label>
                        <div class="input">
                            <input type="text" name="address" class="span7" value="<?php echo $profile['address']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Secondary Address:</label>
                        <div class="input">
                            <input type="text" name="address2" class="span7" value="<?php echo $profile['address2']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="input">
                            <div class="inline-inputs">
                                <label>City, State Zip:</label>
                                <input type="text" name="city" class="span4" value="<?php echo $profile['city']; ?>">
                                <select name="state" class="span2">
                                    <?php echo \formselect::states_option($profile['state']); ?>
                                </select>
                                <input type="text" name="zip" class="span2" value="<?php echo $profile['zip']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>County:</label>
                        <div class="input">
                            <input type="text" name="county" class="span7" value="<?php echo $profile['county']; ?>">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Personal</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Social Security:</label>
                        <div class="input">
                            <input type="text" name="ssn" class="span4" value="<?php echo \format::ssn($profile['ssn']); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Birth Date:</label>
                        <div class="input">
                            <input type="text" id="dob" name="dob" class="span4 datepicker" value="<?php echo date('m/d/Y', strtotime($profile['dob'])); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Marital Status:</label>
                        <div class="input">
                            <select id="marital_status" name="marital_status" class="span3">
                                <option value="Single"<?php if ($profile['marital_status'] == 'Single') { ?> selected="selected"<?php } ?>>Single</option>
                                <option value="Married"<?php if ($profile['marital_status'] == 'Married') { ?> selected="selected"<?php } ?>>Married</option>
                                <option value="Separated"<?php if ($profile['marital_status'] == 'Separated') { ?> selected="selected"<?php } ?>>Separated</option>
                                <option value="Divorced"<?php if ($profile['marital_status'] == 'Divorced') { ?> selected="selected"<?php } ?>>Divorced</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>No. of Dependents:</label>
                        <div class="input">
                            <input type="text" name="num_dependents" class="span2" value="<?php echo $profile['num_dependents']; ?>">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Phones</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Home:</label>
                        <div class="input">
                            <input type="text" name="phone_home" class="span4" value="<?php echo \format::phone($profile['phone_home']); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Mobile:</label>
                        <div class="input">
                            <input type="text" name="phone_mobile" class="span4" value="<?php echo \format::phone($profile['phone_mobile']); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Work:</label>
                        <div class="input">
                            <input type="text" name="phone_work" class="span4" value="<?php echo \format::phone($profile['phone_work']); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Fax:</label>
                        <div class="input">
                            <input type="text" name="phone_fax" class="span4" value="<?php echo \format::phone($profile['phone_fax']); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Preferred Call Time:</label>
                        <div class="input">
                            <select name="best_call_time" class="span3">
                                <option value="Morning"<?php if ($profile['best_call_time'] == 'Morning') { ?> selected="selected"<?php } ?>>Morning</option>
                                <option value="Midday"<?php if ($profile['best_call_time'] == 'Midday') { ?> selected="selected"<?php } ?>>Midday</option>
                                <option value="Afternoon"<?php if ($profile['best_call_time'] == 'Afternoon') { ?> selected="selected"<?php } ?>>Afternoon</option>
                                <option value="Evening"<?php if ($profile['best_call_time'] == 'Evening') { ?> selected="selected"<?php } ?>>Evening</option>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Spousal Information</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>First Name:</label>
                        <div class="input">
                            <input type="text" name="co_first_name" class="span7" value="<?php echo $profile['spouse']['first_name']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Middle Name:</label>
                        <div class="input">
                            <input type="text" name="co_middle_name" class="span7" value="<?php echo $profile['spouse']['middle_name']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Last Name:</label>
                        <div class="input">
                            <input type="text" name="co_last_name" class="span7" value="<?php echo $profile['spouse']['last_name']; ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Email Address:</label>
                        <div class="input">
                            <input type="text" name="co_email" class="span7" value="<?php echo $profile['spouse']['email']; ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Home Phone:</label>
                        <div class="input">
                            <input type="text" name="co_phone_home" class="span4" value="<?php echo \format::phone($profile['spouse']['phone_home']); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Mobile Phone:</label>
                        <div class="input">
                            <input type="text" name="co_phone_mobile" class="span4" value="<?php echo \format::phone($profile['spouse']['phone_mobile']); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Work Phone:</label>
                        <div class="input">
                            <input type="text" name="co_phone_work" class="span4" value="<?php echo \format::phone($profile['spouse']['phone_work']); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Social Security:</label>
                        <div class="input">
                            <input type="text" name="co_ssn" class="span4" value="<?php echo \format::ssn($profile['spouse']['ssn']); ?>">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Birth Date:</label>
                        <div class="input">
                            <input type="text" name="co_dob" class="span4 datepicker" value="<?php echo date('m/d/Y', strtotime($profile['spouse']['dob'])); ?>">
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