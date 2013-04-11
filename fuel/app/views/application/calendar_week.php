<?php echo View::factory('application/notes', $notes)->render();?>

<link href="/css/calendar.css" rel="stylesheet" type="text/css">
<h1>File Task Calendar</h1>
<?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>
<div class="clear"></div>

<div class="span9">
    <div class="row-fluid">
        <div class="span1" style="font-size:28px;font-weight:bold;padding-bottom:25px;"><a href="<?php echo $_SERVER['PATH_INFO']; ?>?w=<?php echo $last_week; ?>" title="Last Week"><img src="/img/icons/calendar_left.png"/></a></div>
        <div class="span9" style="text-align:center;font-size:28px;font-weight:bold;padding-bottom:25px;">Week of <?php echo date('l, n/j/Y', strtotime($base_date)); ?></div>
        <div class="span1" style="text-align:right;font-size:28px;font-weight:bold;padding-bottom:25px;"><a href="<?php echo $_SERVER['PATH_INFO']; ?>?w=<?php echo $next_week; ?>" title="Next Week"><img src="/img/icons/calendar_right.png"/></a></div>
    </div>
</div>

<div class="span9" style="margin-bottom:10px;">
    <a href="/application/calendar/<?php echo URI::segment(3); ?>" class="btn small">Month Calendar</a>
    <a href="/application/calendar_week/<?php echo URI::segment(3); ?>" class="btn small">Week Calendar</a>
    <a href="/application/calendar_day/<?php echo URI::segment(3); ?>" class="btn small">Day Calendar</a>
</div>

<style>
.calendar .appointments .details {
    font-size:10px;
    display:none;
}
.calendar .appointments .details span {
    display:block;
}
.calendar .appointment {
    margin-bottom: 5px;
}
</style>

<div class="span7">
    <?php echo $calendar->getWeekCalendar(); ?>
</div>
<div class="span2">
    <?php echo View::factory('application/calendar_filters')->render(); ?>
</div>