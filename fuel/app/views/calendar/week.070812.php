<link href="/css/calendar.css" rel="stylesheet" type="text/css">

<div class="span9">
    <h1>Weekly Calendar</h1>

    <div class="row-fluid">
        <div class="span1" style="font-size:28px;font-weight:bold;padding-bottom:25px;"><a href="<?php echo $_SERVER['PATH_INFO']; ?>?w=<?php echo strtotime('-1 week', strtotime($base_date)); ?>" title="Last Week"><img src="/img/icons/calendar_left.png"/></a></div>
        <div class="span7" style="text-align:center;font-size:28px;font-weight:bold;padding-bottom:25px;">Week of <?php echo date('l, n/j/Y', strtotime($base_date)); ?></div>
        <div class="span1" style="text-align:right;font-size:28px;font-weight:bold;padding-bottom:25px;"><a href="<?php echo $_SERVER['PATH_INFO']; ?>?w=<?php echo strtotime('+1 week', strtotime($base_date)); ?>" title="Next Week"><img src="/img/icons/calendar_right.png"/></a></div>
    </div>

    <div style="margin-bottom:10px;">
        <a href="/calendar/month/" class="btn small">Month Calendar</a>
        <a href="/calendar/week/" class="btn small">Week Calendar</a>
        <a href="/calendar/day/" class="btn small">Day Calendar</a>
    </div>

    <?php echo $calendar->getWeekCalendar(); ?>
    
</div>