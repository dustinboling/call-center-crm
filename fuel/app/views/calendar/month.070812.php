<link href="/css/calendar.css" rel="stylesheet" type="text/css">
<h1>Calendar</h1>

    <div class="row-fluid">
        <div class="span1" style="font-size:28px;font-weight:bold;padding-bottom:25px;"><a href="<?php echo $_SERVER['PATH_INFO']; ?>?m=<?php echo date('m', strtotime('-1 month', strtotime($base_date))); ?>&y=<?php echo date('y', strtotime('-1 month', strtotime($base_date))); ?>" title="Last Month"><img src="/img/icons/calendar_left.png"/></a></div>
        <div class="span9" style="text-align:center;font-size:28px;font-weight:bold;padding-bottom:25px;"><?php echo date('F Y', strtotime($base_date)); ?></div>
        <div class="span1" style="text-align:right;font-size:28px;font-weight:bold;padding-bottom:25px;"><a href="<?php echo $_SERVER['PATH_INFO']; ?>?m=<?php echo date('m', strtotime('+1 month', strtotime($base_date)));; ?>&y=<?php echo date('y', strtotime('+1 month', strtotime($base_date))); ?>" title="Next Month"><img src="/img/icons/calendar_right.png"/></a></div>
    </div>

    <div style="margin-bottom:10px;">
        <a href="/calendar/month/" class="btn small">Month Calendar</a>
        <a href="/calendar/week/" class="btn small">Week Calendar</a>
        <a href="/calendar/day/" class="btn small">Day Calendar</a>
    </div>

<?php echo $calendar->getMonthCalendar(); ?>