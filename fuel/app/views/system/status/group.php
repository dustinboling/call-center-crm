<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Select a Status Group</h1>

<ul>
    <?php foreach($groups as $g):?>
    <li><a href="/system/status/listing/<?php echo $g['id'];?>"><?php echo $g['name'];?></a></li>
    <?php endforeach;?>
</ul>