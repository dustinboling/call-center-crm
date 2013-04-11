<?php echo View::factory('application/notes', $notes)->render();?>

<style>
    h3 { margin-top: 25px; }
    h3.first { margin-top: 5px; }
</style>

<div class="row-fluid">
<div class="span9">
    
<h1>File Overview</h1>
<div><?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?></div>
<div class="clear"></div>
    
<div class="row-fluid">
        <div class="span3">
            <h2>Status:</h2>
            <div class="row-fluid">
                <div class="span6"><strong>Priority Level:</strong></div>
                <div class="span6" style="text-align:right">
                    <select name="priority_level" class="span2" id="update_priority_level">
                        <option value="1"<?php ($application['application']['priority_level'] == 1?print ' selected':'');?>>Level 1</option>
                        <option value="2"<?php ($application['application']['priority_level'] == 2?print ' selected':'');?>>Level 2</option>
                        <option value="3"<?php ($application['application']['priority_level'] == 3?print ' selected':'');?>>Level 3</option>
                        <option value="4"<?php ($application['application']['priority_level'] == 4?print ' selected':'');?>>Level 4</option>
                        <option value="5"<?php ($application['application']['priority_level'] == 5?print ' selected':'');?>>Level 5</option>
                    </select>
                </div>
            </div>
            
            <div class="row-fluid">
                <div class="span2"><strong>Payment Status:</strong></div>
                <div class="span2" style="text-align:right">
                    <select name="payment_status_id" class="span2" id="update_payment_status">
                        <option value="1"<?php ($application['application']['payment_status_id'] == 1?print ' selected':'');?>>Current</option>
                        <option value="2"<?php ($application['application']['payment_status_id'] == 2?print ' selected':'');?>>NSF</option>
                    </select>
                </div>
            </div>
            
            <div class="row-fluid">
                <div class="span2"><strong>Workflow Status:</strong></div>
                <div class="span2" style="text-align:right">
                    <?php echo $application['application']['current_status'];?>
                </div>
            </div>
            
        </div>
        
        <div class="span4">
            <h2>Actions:</h2>
            <div class="row-fluid">
                <div class="span4">
                    <form action="/application/run_action/<?php echo $application['application']['id'];?>" method="post">
                    <input type="hidden" name="app_id" value="<?php echo $application['application']['id'];?>">    
                    <select name="action_id" class="span4">
                        <?php foreach($actions as $a):?>
                        <option value="<?php echo $a['id'];?>"><?php echo $a['name'];?></option>
                        <?php endforeach;?>
                    </select>
                    <button type="submit" class="btn primary">Run</button>
                    </form>
                </div>
            </div>    
        </div>
        
        <div class="clear"></div>
        
        <hr style="margin-left: 20px;">
        
    </div>
    
    <div class="row-fluid">
        <div class="span4">
            
            <h2>Summary:</h2>

            <h3 class="first">Personal Finances:</h3>

            <div class="row-fluid">
                <div class="span2"><strong>Income:</strong></div>
                <div class="span2" style="text-align:right">
                <?php
                $total = 0;
                foreach ($application['finances']['personal']['income'] as $k => $v) {
                    if (is_numeric($v)) {
                        $total = $total + $v;
                    }
                }
                echo '$'.number_format($total, 2);
                ?>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span2"><strong>Assets:</strong></div>
                <div class="span2" style="text-align:right">
                <?php
                $total = 0;
                foreach ($application['finances']['personal']['assets'] as $k => $v) {
                    if (is_numeric($v)) {
                        $total = $total + $v;
                    }
                }
                echo '$'.number_format($total, 2);
                ?>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span2"><strong>Monthly Expenses:</strong></div>
                <div class="span2" style="text-align:right">
                <?php
                $total = 0;
                foreach ($application['finances']['personal']['expenses'] as $k => $v) {
                    if (is_numeric($v)) {
                        $total = $total + $v;
                    }
                }
                echo '$'.number_format($total, 2);
                ?>
                </div>
            </div>

            <?php if ($application['tax_problem']['tax_type'] != 'Personal') { ?>

            <h3>Business Finances</h3>

            <div class="row-fluid">
                <div class="span2"><strong>Income:</strong></div>
                <div class="span2" style="text-align:right">
                <?php
                $total = 0;
                foreach ($application['finances']['business']['income'] as $k => $v) {
                    if (is_numeric($v)) {
                        $total = $total + $v;
                    }
                }
                echo '$'.number_format($total, 2);
                ?>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span2"><strong>Assets:</strong></div>
                <div class="span2" style="text-align:right">
                <?php
                $total = 0;
                foreach ($application['finances']['business']['assets'] as $k => $v) {
                    if (is_numeric($v)) {
                        $total = $total + $v;
                    }
                }
                echo '$'.number_format($total, 2);
                ?>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span2"><strong>Monthly Expenses:</strong></div>
                <div class="span2" style="text-align:right">
                <?php
                $total = 0;
                foreach ($application['finances']['business']['expenses'] as $k => $v) {
                    if (is_numeric($v)) {
                        $total = $total + $v;
                    }
                }
                echo '$'.number_format($total, 2);
                ?>
                </div>
            </div>

            <?php } ?>

            <h3>Pinnacle Fees:</h3>

            <div class="row-fluid">
                <div class="span2"><strong>Total Fees:</strong></div>
                <div class="span2" style="text-align:right">
                <?php
                $total = 0;
                foreach ($application['tax_problem']['fees'] as $k => $v) {
                    if (is_numeric($v)) {
                        $total = $total + $v;
                    }
                }
                echo '$'.number_format($total, 2);
                ?>
                </div>
            </div>

            <h3>Time:</h3>

            <div class="row-fluid">
                <div class="span3">Work on File</div>
                <div class="span2" style="text-align:right"><?php echo number_format((($time_spent[Uri::segment(3)] / 60) / 60), 2); ?> Hours</div>
                <div class="span2"><a href="/application/punches/<?php echo Uri::segment(3); ?>" class="btn small">Manage Punch Clock</a></div>
            </div>

            <h3>Qualification:</h3>

            <div class="row-fluid">
                <div class="span2">Do Some Math?</div>
                <div class="span2" style="text-align:right">&nbsp;</div>
            </div>

        </div>
        <div class="span4">
            <h2>Tax Overview:</h2>

            <h3 class="first">Problem:</h3>

            <div class="row-fluid">
                <div class="span2"><strong>Total Tax Liability:</strong></div>
                <div class="span2">$<?php echo number_format($application['tax_problem']['tax_liability'], 2); ?></div>
            </div>
            <div class="row-fluid">
                <div class="span2"><strong>Total Type:</strong></div>
                <div class="span2"><?php echo $application['tax_problem']['tax_type']; ?></div>
            </div>
            <div class="row-fluid">
                <div class="span2"><strong>Agency:</strong></div>
                <div class="span2"><?php echo $application['tax_problem']['tax_agency']; ?></div>
            </div>
            <div class="row-fluid">
                <div class="span2"><strong>IRS Letter:</strong></div>
                <div class="span2"><?php if ($application['tax_problem']['irs_letter_received']) { echo 'Yes'; } else { echo 'No'; } ?></div>
            </div>
            <div class="row-fluid">
                <div class="span2"><strong>Bankruptcy:</strong></div>
                <div class="span2"><?php if ($application['tax_problem']['in_bankruptcy']) { echo 'Yes'; } else { echo 'No'; } ?></div>
            </div>

            <h3>Activity:</h3>
            <?php if (!empty($application['tax_activity'])) { ?>
            <?php foreach ($application['tax_activity'] as $k => $v) { ?>
                <?php foreach ($v as $y => $z) { ?>
                    <?php if ($z['owed'] || $z['not_filed']) { ?>
                    <div class="row-fluid">
                        <div class="span2"><strong><?php echo $z['branch'].' '.$z['year']; ?></strong></div>
                        <div class="span2">
                            <?php if ($z['owed']) { echo 'Owed'; } else { echo 'Not Owned'; } ?>
                        </div>
                        <div class="span2">
                            <?php if ($z['not_filed']) { echo 'Unfiled'; } else { echo 'Filed'; } ?>
                        </div>
                    </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
</div>

<div class="span4">
    <h2>Account:</h2>
    <h3 class="first">Contact Info:</h3>
    <p>
        <?php echo $application['profile']['first_name']; ?> <?php echo $application['profile']['middle_name']; ?> <?php echo $application['profile']['last_name']; ?><br/>
        <?php echo $application['profile']['address']; ?><br/>
        <?php if (!empty($application['profile']['address2'])){ echo $application['profile']['address2']."<br/>"; } ?>
        <?php echo $application['profile']['city']; ?>, <?php echo $application['profile']['state']; ?> <?php echo $application['profile']['zip']; ?><br/>
        <?php echo $application['profile']['county']; ?>
    </p>
    <p>
        Date of Birth: <?php echo date('m/d/Y', strtotime($application['profile']['dob'])); ?><br/>
        Social Security: <?php echo \format::ssn($application['profile']['ssn']); ?><br/>
    </p>
    <p>
        Home: <?php echo \format::phone($application['profile']['phone_home']); ?><br/>
        Work: <?php echo \format::phone($application['profile']['phone_work']); ?><br/>
        Mobile: <?php echo \format::phone($application['profile']['phone_mobile']); ?><br/>
        Fax: <?php echo \format::phone($application['profile']['phone_fax']); ?><br/>
        Email: <a href="mailto:<?php echo $application['profile']['email']; ?>"><?php echo $application['profile']['email']; ?></a><br/>
        Best Call Time: <?php echo $application['profile']['best_call_time']; ?><br/>
    </p>
    <p>Marital Status: <?php echo $application['profile']['marital_status']; ?></p>
    <?php if (strlen($application['profile']['spouse']['first_name'])) { ?>
    <p>
    <strong>Spouse:</strong><br/>
    <?php echo $application['profile']['spouse']['first_name']; ?> <?php echo $application['profile']['spouse']['middle_name']; ?> <?php echo $application['profile']['spouse']['last_name']; ?><br/>
        Home: <?php echo \format::phone($application['profile']['spouse']['phone_home']); ?><br/>
        Work: <?php echo \format::phone($application['profile']['spouse']['phone_work']); ?><br/>
        Mobile: <?php echo \format::phone($application['profile']['spouse']['phone_mobile']); ?><br/>
        Date of Birth: <?php echo date('m/d/Y', strtotime($application['profile']['spouse']['dob'])); ?><br/>
        Social Security: <?php echo \format::ssn($application['profile']['spouse']['ssn']); ?><br/>
    </p>
    <?php } ?>

</div>

<?php
//echo '<div class="span16">';
//echo '<p>';
//echo '<pre>';
//print_r($application);
//echo '</pre>';
//echo '</p>';
//echo '</div>';
?>


<script type="text/javascript">

$(document).ready(function(e){
   $("#update_payment_status").change(function(e){
     $.post('/application/quick_update/<?php echo $application['application']['id'];?>', {payment_status_id: $(this).val()});  
   });
   
   $("#update_priority_level").change(function(e){
     $.post('/application/quick_update/<?php echo $application['application']['id'];?>', {priority_level: $(this).val()});  
   });
});

</script>