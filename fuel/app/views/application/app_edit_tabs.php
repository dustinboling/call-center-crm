<?php

    if(is_numeric(Uri::segment(3))){
        $app_id = Uri::segment(3);
    }elseif(is_numeric(Uri::segment(4))){
        $app_id = Uri::segment(4);
    }
    
 ?>

<div style="text-align:right; margin: -52px 0 10px 0;">
    <a href="/application/clockout/<?php echo $app_id; ?>" class="btn small info">Clock Out</a>
</div>
<div class="alert-message block-message info" style="font-size:18px; text-align:center;">Current File: <?php echo $customer; ?></div>
<?php /*<div style="margin-top:-20px;"><?php echo View::factory('application/app_edit_notes')->render(); ?></div>*/?>
<ul class="nav nav-tabs">
    <li<?php if (Uri::segment(2) == 'view') { echo ' class="active"'; } ?>>
        <a href="/application/view/<?php echo $app_id; ?>">Summary</a>
    </li>
    <li<?php if (Uri::segment(2) == 'activity') { echo ' class="active"'; } ?>>
        <a href="/application/activity/<?php echo $app_id; ?>">Activity</a>
    </li>
    <li class="<?php if (Uri::segment(2) == 'documents') { echo 'active '; } ?> dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Documents <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/application/documents/<?php echo $app_id;?>">Uploaded Documents</a></li>
            <li><a href="/application/forms/<?php echo $app_id; ?>">Send Forms</a></li>
        </ul>
    </li>
    <li<?php if (Uri::segment(2) == 'calendar') { echo ' class="active"'; } ?>>
        <a href="/application/calendar_day/<?php echo $app_id; ?>">File Calendar</a>
    </li>
    <li class="<?php if (in_array(Uri::segment(2), array('profile','employment','billing'))) { echo 'active '; } ?>dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Customer Profile <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="/application/profile/<?php echo $app_id; ?>">Customer Info</a>
            </li>
            <li>
                <a href="/application/employment/<?php echo $app_id; ?>">Employment</a>
            </li>
            <li>
                <a href="/application/billing/<?php echo $app_id; ?>">Billing</a>
            </li>
        </ul>
    </li>
    <li class="<?php if (in_array(Uri::segment(2), array('personal','business'))) { echo 'active '; } ?>dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Customer Finances <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="/application/personal/<?php echo $app_id; ?>">Personal</a>
            </li>
            <li>
                <a href="/application/business/<?php echo $app_id; ?>">Business</a>
            </li>
        </ul>
    </li>
    <li<?php if (Uri::segment(2) == 'tax') { echo ' class="active"'; } ?>>
        <a href="/application/tax/<?php echo $app_id; ?>">Tax Info</a>
    </li>
    <li class="<?php if (in_array(Uri::segment(2), array('fees','payments','upsell'))) { echo 'active '; } ?>dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Accounting <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="/application/fees/<?php echo $app_id; ?>">Fees Schedule</a>
            </li>
            <li>
                <a href="/application/payments/<?php echo $app_id; ?>">Payments</a>
            </li>
            <?php /*<li>
                <a href="/application/upsell/<?php echo $app_id; ?>">Upsell</a>
            </li>*/?>
        </ul>
    </li>
</ul>
<div class="clear"></div>