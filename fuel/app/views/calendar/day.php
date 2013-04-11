<h1>Calendar</h1>

<?php echo View::factory('calendar/tabs')->render();?>

<h2><?php echo $day->getDate()->format('F j, Y');?></h2>

<?php 
$yesterday = clone $day->getDate();
$tomorrow = clone $day->getDate();
$yesterday->modify('-1 day');
$tomorrow->modify('+1 day');
?>


<div class="well"><a href="/calendar/day/?d=<?php echo $yesterday->format('Y-m-d');?>" class="btn">Yesterday</a> <a href="/calendar/day/?d=<?php echo $tomorrow->format('Y-m-d');?>" class="btn">Tomorrow</a></div>

<?php echo $day;?>
