<h1>Calendar</h1>
<h1>Weekly Calendar</h1>

<?php echo View::factory('calendar/tabs')->render();?>

<h2>Week of <?php echo $week->getWeekStartDate()->format('F jS');?></h2>

<?php 
$last = clone $week->getDate();
$next = clone $week->getDate();
$last->modify('-1 week');
$next->modify('+1 week');
?>

<div class="well"><a href="/calendar/week/?d=<?php echo $last->format('Y-m-d');?>" class="btn">Last Week</a> <a href="/calendar/week/?d=<?php echo $next->format('Y-m-d');?>" class="btn">Next Week</a></div>

<?php echo $week;?>
