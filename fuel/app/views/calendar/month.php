<h1>Calendar</h1>

<?php echo View::factory('calendar/tabs')->render();?>

<h2><?php echo $month->getDate()->format('F Y');?></h2>

<?php 
$last = clone $month->getDate();
$next = clone $month->getDate();
$last->modify('-1 month');
$next->modify('+1 month');
?>
</div>



<div class="well"><a href="/calendar/month/?d=<?php echo $last->format('Y-m-d');?>" class="btn">Last Month</a> <a href="/calendar/month/?d=<?php echo $next->format('Y-m-d');?>" class="btn">Next Month</a></div>

<?php echo $month;?>
