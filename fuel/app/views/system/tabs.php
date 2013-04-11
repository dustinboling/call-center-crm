<ul class="nav nav-tabs">
    <li class="<?php (uri::segment(3)=='listing' ? print 'active':'');?>"><a href="/system/<?php echo uri::segment(2);?>/listing/<?php echo uri::segment(4);?>">Listing</a></li>
    <li class="<?php (uri::segment(3)=='add' ? print 'active':'');?>"><a href="/system/<?php echo uri::segment(2);?>/add/<?php echo uri::segment(4);?>">Add</a></li>
    <?php if(uri::segment(3) == 'update'):?><li class="active"><a href="#">Update</a></li><?php endif;?>
</ul>

<div class="clear"></div>