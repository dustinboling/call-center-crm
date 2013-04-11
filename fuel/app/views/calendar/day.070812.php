<link href="/css/calendar.css" rel="stylesheet" type="text/css">
<h1>Daily Calendar</h1>

    <div class="row-fluid">
        <div class="span1" style="font-size:28px;font-weight:bold;padding-bottom:25px;"><a href="<?php echo $_SERVER['PATH_INFO']; ?>?d=<?php echo strtotime('-1 day', strtotime($base_date)); ?>" title="Yesterday"><img src="/img/icons/calendar_left.png"/></a></div>
        <div class="span7" style="text-align:center;font-size:28px;font-weight:bold;padding-bottom:25px;"><?php echo date('l, n/j/Y', strtotime($base_date)); ?></div>
        <div class="span1" style="text-align:right;font-size:28px;font-weight:bold;padding-bottom:25px;"><a href="<?php echo $_SERVER['PATH_INFO']; ?>?d=<?php echo strtotime('+1 day', strtotime($base_date)); ?>" title="Tomorrow"><img src="/img/icons/calendar_right.png"/></a></div>
    </div>

    <div style="margin-bottom:10px;">
        <a href="/calendar/month/" class="btn small">Month Calendar</a>
        <a href="/calendar/week/" class="btn small">Week Calendar</a>
        <a href="/calendar/day/" class="btn small">Day Calendar</a>
    </div>

<?php echo $calendar->getDayCalendar(); ?>