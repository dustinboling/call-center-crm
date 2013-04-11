<!DOCTYPE html>
<html>
    <head>
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="/css/screen_front.css" rel="stylesheet" type="text/css">
        <link href="/css/jqueryui/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/js/jquery.populate.js"></script>
        <script type="text/javascript" src="/js/global.js"></script>
    </head>
    <body>
        <?php Notify::showFlash(); ?>
        <div class="container-fluid">
            <div class="row-fluid" style="margin-top: 10px;">
                <div class="span6">
                    <div style="padding-top: 10px;"><?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'];?>, <a href="/account/signout">sign out</a></div>
                </div>    
                <div class="span6" style="text-align: right;">
                    
                    <form action="/case/quick_search" method="post" style="display:inline-block; margin-right: 10px;">
                    <input type="text" name="query" style="margin-bottom: 0;"> <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                    
                    <a href="/case/quick_add" class="btn btn-success"><i class="icon-white icon-plus-sign"></i> New Case</a>     
                </div>
            </div>    
        </div>
        
        <form action="/case/save_quick_update/<?php echo $id;?>" method="post" id="form">
        <div class="container-fluid">

            <div class="row-fluid">
                
                <div class="span12">
                    <table class="table table-bordered case_bar table-condensed">
                        <tr>
                            <td rowspan="2" class="alert alert-info id">
                                <a href="/case/update/<?php echo $case['id'];?>"><?php echo $case['id'];?></a>
                                <div style="font-size: 12px; font-weight: bold; margin-top: 5px;"><?php echo $case['first_name'];?> <?php echo $case['last_name'];?></div>
                                <div style="font-size: 12px; margin-top: 5px;"><?php echo date('m/d/y', strtotime($case['created']));?></div>
                            </td>
                            <td class="ttl">Status</th>
                            <td class="field">
                                <select name="status_id" style="margin-bottom: 0;">
                                    <?php foreach($statuses as $s):?>
                                        <option value="<?php echo $s['id'];?>"><?php echo $s['name'];?></option>
                                        <?php endforeach;?>
                                </select>
                            </td>
                            <td class="ttl">User</td>
                            <td class="field">
                                <select name="sales_rep_id" class="input-medium" style="margin-bottom: 0;">
                                    <?php foreach($users as $u):?>
                                    <option value="<?php echo $u['id'];?>"><?php echo $u['first_name'] . ' ' . $u['last_name'];?></option>
                                    <?php endforeach;?>
                                </select>                                
                            </td>
                            <td rowspan="2" class="c" width="75" style="vertical-align: middle;">
                                <button class="btn btn-info" type="submit">Save All</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="ttl">Campaign</td>
                            <td class="field">
                                <select name="campaign_id" style="margin-bottom: 0;">
                                    <option value=""></option>
                                    <?php foreach($campaigns as $c):?>
                                    <option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <td class="ttl">Timezone</td>
                            <td class="field" style="margin-bottom: 0;">
                                <select name="timezone" class="input-medium">
                                    <option value="Pacific">Pacific</option>
                                    <option value="Mountain">Mountain</option>
                                    <option value="Central">Central</option>
                                    <option value="Eastern">Eastern</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    
                    <div style="overflow: scroll; height: 300px;">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($activity as $a):?>
                                <tr>
                                    <td width="125">
                                        <small><?php (empty($a['name'])? print 'System Action':print $a['name']);?></small><br>
                                        <span class="label"><?php echo format::relative_date($a['ts']);?></span>
                                    </td>
                                    <td><?php echo $a['message'];?><?php if(!empty($a['note'])):?><br><small><?php echo $a['note'];?></small><?php endif;?></td>
                                    
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    
                    <table class="table table-bordered table-striped table-condensed">
                        <tr>
                            <td width="75">Call Notes</td>
                            <td><textarea name="note" class="w90"></textarea></td>
                        </tr>    
                        <tr>
                            <td>Action</td>
                            <td>
                                <select name="action_id" id="action_id" style="margin-bottom: 0;">
                                    <?php foreach($actions as $a):?>
                                    <option value="<?php echo $a['id'];?>" data-task="<?php echo $a['set_task'];?>"><?php echo $a['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                                <button class="btn btn-primary" type="submit" name="run_action" id="run_action">Run Action and Save All</button>
                            </td>
                        </tr>    
                        <tr>
                            <td colspan="2">
                                <table class="table table-striped table-bordered" id="set_appointment">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Set an Appointment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Title</td>
                                            <td><input type="text" name="event[title]" class="input-xlarge"></td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td><textarea name="event[description]" style="margin-top: 10px; width: 95%;"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td>When</td>
                                            <td>
                                                <input type="text" name="event[date]" class="datepicker input-small" placeholder="Date">
                                                <input type="text" name="event[time]" class="input-small" placeholder="12:00pm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Reminder</td>
                                            <td>
                                                <select name="event[alert_offset]" class="input-medium">
                                                    <option value="0">At time of event</option>
                                                    <option value="-5 minutes">5 minutes before</option>
                                                    <option value="-15 minutes">15 minutes before</option>
                                                    <option value="-30 minutes">30 minutes before</option>
                                                    <option value="-1 hour">1 hour before</option>
                                                    <option value="-2 hours">2 hours before</option>
                                                    <option value="-1 day">1 day before</option>
                                                    <option value="-2 days">2 days before</option>
                                                </select> 
                                                <input type="checkbox" name="event[alert_email]" value="1"> Email 
                                                <input type="checkbox" name="event[alert_popup]" value="1"> Popup
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><button class="btn btn-primary" name="with_event" type="submit">Run Action and Set Appointment</button>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>    
                        </tr>
                    </table>    
                    
                </div>
            </div>
            
            <div class="row-fluid">
                
                <div class="span6">
                    <table class="table table-striped table-bordered table-condensed">

                        <tr>
                            <td width="125">Name</td>
                            <td>
                                <input type="text" name="first_name" placeholder="First" class="input-small" value="<?php echo $case['first_name'];?>">
                                <input type="text" name="last_name" placeholder="Last" class="input-small" value="<?php echo $case['last_name'];?>">
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
            
            <div class="form-actions"><button class="btn btn-info" type="submit">Save All</button></div>
            
        </div>
        </form>
        
        <script type="text/javascript">
        $(document).ready(function(){
           $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($case)?json_encode($case):'')); ?>);
           
           $("#action_id").change(function(e){
                if($("#action_id option:selected").attr('data-task') == 1){
                    $("#set_appointment").show();
                    $("#run_action").hide();
                }else{
                    $("#set_appointment").hide();
                    $("#run_action").show();
                }
            });
           
        });
        </script>
        
    </body>
</html>