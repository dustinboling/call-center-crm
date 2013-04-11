<!DOCTYPE html>
<html>
    <head>
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="/css/screen_front.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="/js/jquery.populate.js"></script>
    </head>
    <body>
        <?php Notify::showFlash(); ?>
        <div class="container-fluid">
            <div class="row-fluid" style="margin-top: 10px;">
                
                <h1>Add a Case</h1>
                <form action="/case/quick_add" method="post" id="form">
                    <div class="row-fluid">

                        <div class="span6">
                            <table class="table table-striped table-bordered table-condensed">

                                <tr>
                                    <td width="125">Name</td>
                                    <td>
                                        <input type="text" name="first_name" placeholder="First" class="input-small">
                                        <input type="text" name="last_name" placeholder="Last" class="input-small">
                                    </td>
                                </tr>       
                                <tr>
                                    <td>User</td>
                                    <td>
                                        <select name="sales_rep_id" class="input-medium" style="margin-bottom: 0;">
                                            <option value=""></option>
                                            <?php foreach($users as $u):?>
                                            <option value="<?php echo $u['id'];?>"><?php echo $u['first_name'] . ' ' . $u['last_name'];?></option>
                                            <?php endforeach;?>
                                        </select>  
                                    </td>
                                </tr>
                                <tr>
                                    <td>Campaign</td>
                                    <td>
                                    <select name="campaign_id" style="margin-bottom: 0;">
                                        <option value=""></option>
                                        <?php foreach($campaigns as $c):?>
                                        <option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Federal Tax Liability</td>
                                    <td><input type="text" name="federal_tax_liability"></td>
                                </tr>
                                <tr>
                                    <td>State Tax Liability</td>
                                    <td><input type="text" name="state_tax_liability"></td>
                                </tr>

                            </table>        
                        </div>

                        <div class="span6">
                            <table class="table table-striped table-bordered table-condensed">
                                <tr>
                                    <td>Primary Phone</td>
                                    <td><input type="text" name="primary_phone"></td>
                                </tr>
                                <tr>
                                    <td>Secondary Phone</td>
                                    <td><input type="text" name="secondary_phone"></td>
                                </tr>
                                <tr>
                                    <td>Mobile Phone</td>
                                    <td><input type="text" name="mobile_phone"></td>
                                </tr>
                            </table>
                        </div>     

                    </div>

                    <div class="clear"></div>

                    <div class="form-actions"><button class="btn btn-primary" type="submit">Save</button></div>

                </form>

            </div>
        </div>
    </body>
</html>
