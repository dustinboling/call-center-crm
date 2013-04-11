<h1 class="span16">New Customers</h1>
<div class="clear"></div>

<form action="/application/add" method="post" class="form-stacked">
    <fieldset>
        <table class="zebra-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>New Application Information</h2>
                    <input type="hidden" name="service_id" value="1" />
                    <input type="hidden" name="service_type_id" value="1" />
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    Assignment of Personnel
                </td>
                <td>
                    Assignment of Personnel
                </td>
            </tr>
        </table>
        <table class="zebra-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Client Information</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>First Name</label>
                        <div class="input">
                            <input type="text" name="first_name" class="span7">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Middle Name</label>
                        <div class="input">
                            <input type="text" name="middle_name" class="span7">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Last Name</label>
                        <div class="input">
                            <input type="text" name="last_name" class="span7">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Email Address</label>
                        <div class="input">
                            <input type="text" name="email" class="span7">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Primary Address</label>
                        <div class="input">
                            <input type="text" name="address" class="span7">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Secondary Address</label>
                        <div class="input">
                            <input type="text" name="address2" class="span7">
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="input">
                            <div class="inline-inputs">
                                <label>City, State Zip</label>
                                <input type="text" name="city" class="span4">
                                <select name="state" class="span2">
                                    <option selected="selected">State</option>
                                    <option value="AL">Alabama</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="DC">District Of Columbia</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WA">Washington</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                                <input type="text" name="zip" class="span2">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>County</label>
                        <div class="input">
                            <input type="text" name="county" class="span7">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="zebra-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Personal</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Social Security</label>
                        <div class="input">
                            <input type="text" name="ssn" class="span4">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Birth Date</label>
                        <div class="input">
                            <input type="text" id="dob" name="dob" class="span4 datepicker">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Marital Status</label>
                        <div class="input">
                            <select id="marital_status" name="marital_status" class="span3">
                                <option value="single" selected="selected">Single</option>
                                <option value="married">Married</option>
                                <option value="separated">Separated</option>
                                <option value="divorced">Divorced</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>No. of Dependents</label>
                        <div class="input">
                            <input type="text" name="ssn" class="span2">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="zebra-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Phones</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Home</label>
                        <div class="input">
                            <input type="text" name="phone_home" class="span4">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Mobile</label>
                        <div class="input">
                            <input type="text" name="phone_mobile" class="span4">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Work</label>
                        <div class="input">
                            <input type="text" name="phone_work" class="span4">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Fax</label>
                        <div class="input">
                            <input type="text" name="phone_fax" class="span4">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Preferred Call Time</label>
                        <div class="input">
                            <select name="best_call_time" class="span3">
                                <option value="morning">Morning</option>
                                <option value="midday">Midday</option>
                                <option value="afternoon">Afternoon</option>
                                <option value="evening" selected="selected">Evening</option>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="zebra-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Employment</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>Employment Status</label>
                        <div class="input">
                            <select name="employment_type" class="span3">
                                <option value="morning">Employed</option>
                                <option value="midday">Unemployed</option>
                                <option value="afternoon">Business Owner/ Self-Employed</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Company Name</label>
                        <div class="input">
                            <input type="text" name="company_name" class="span7">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Position/ Title</label>
                        <div class="input">
                            <input type="text" name="title" class="span7">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Job Description</label>
                        <div class="input">
                            <input type="text" name="description" class="span7">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Business Owner Info</label>
                    </div>
                    <div class="clearfix">
                        <label>Employer ID</label>
                        <div class="input">
                            <input type="text" name="employer_id" class="span7">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Business Taxes</label>
                        <div class="input">
                            <input type="text" name="business_taxes" class="span7">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="zebra-striped" cellpadding="0" cellspacing="0">
            <tr class="tablecollapse">
                <td colspan="2">
                    <h2>Spousal Information</h2>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="clearfix">
                        <label>First Name</label>
                        <div class="input">
                            <input type="text" name="spouse_first_name" class="span7">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Middle Name</label>
                        <div class="input">
                            <input type="text" name="spouse_middle_name" class="span7">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Last Name</label>
                        <div class="input">
                            <input type="text" name="spouse_last_name" class="span7">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Email Address</label>
                        <div class="input">
                            <input type="text" name="spouse_email" class="span7">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clearfix">
                        <label>Home Phone</label>
                        <div class="input">
                            <input type="text" name="spouse_phone_home" class="span4">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Mobile Phone</label>
                        <div class="input">
                            <input type="text" name="spouse_phone_mobile" class="span4">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Work Phone</label>
                        <div class="input">
                            <input type="text" name="spouse_phone_work" class="span4">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Social Security</label>
                        <div class="input">
                            <input type="text" name="spouse_ssn" class="span4">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label>Birth Date</label>
                        <div class="input">
                            <input type="text" id="spouse_dob" name="spouse_dob" class="span4 datepicker">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <input type="submit" value="Create New Application" class="btn primary" style="margin-top:10px;" />
    </fieldset>
    <div class="clear"></div>
</form>