<?php echo View::factory('application/notes', $notes)->render();?>

<link href="/css/calendar.css" rel="stylesheet" type="text/css">
<h1>File Task Calendar</h1>
<?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>
<div class="clear"></div>

<div class="span9">
    <div class="row">
        <div class="span1" style="font-size:28px;font-weight:bold;padding-bottom:25px;"><a href="<?php echo $_SERVER['PATH_INFO']; ?>?d=<?php echo $yesterday; ?>" title="Yesterday"><img src="/img/icons/calendar_left.png"/></a></div>
        <div class="span9" style="text-align:center;font-size:28px;font-weight:bold;padding-bottom:25px;"><?php echo date('l, n/j/Y', strtotime($base_date)); ?></div>
        <div class="span1" style="text-align:right;font-size:28px;font-weight:bold;padding-bottom:25px;"><a href="<?php echo $_SERVER['PATH_INFO']; ?>?d=<?php echo $tomorrow; ?>" title="Tomorrow"><img src="/img/icons/calendar_right.png"/></a></div>
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
    <?php echo $calendar->getDayCalendar(); ?>
</div>
<div class="span2">
    <?php echo View::factory('application/calendar_filters')->render(); ?>
    <strong>Hours:</strong>
    <ul style="list-style: none;margin-left:0;">
        <li><input type="checkbox" id="hours_overnight" /> Overnight</li>
        <li><input type="checkbox" id="hours_morning" checked="checked" /> Morning</li>
        <li><input type="checkbox" id="hours_midday" checked="checked" /> Midday</li>
        <li><input type="checkbox" id="hours_afternoon" checked="checked" /> Afternoon</li>
        <li><input type="checkbox" id="hours_evening" checked="checked" /> Evening</li>
    </ul>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $(function(){
            $(".overnight").hide();
        });
        $("#hours_overnight, #hours_morning, #hours_midday, #hours_afternoon, #hours_evening").click(function(){
            var id = this.id;
            var elm = id.split('_');
            if($("#"+id).is(':checked')) {
                $(".calendar tr."+elm[1]).show();
            } else {
                $(".calendar tr."+elm[1]).hide();
            }
        });
    });
</script>