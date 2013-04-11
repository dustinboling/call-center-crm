

    <ul class="nav nav-tabs">
        <li<?php if (Uri::segment(2) == 'listing') { echo ' class="active"'; } ?>><a href="/application/listing">Customer Files</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Priority Levels</a>
            <ul class="dropdown-menu">
                <li><a href="/application/by_filter/?priority=1" style="text-shadow: none;"><?php echo format::priority_level(1);?></a></li>
                <li><a href="/application/by_filter/?priority=2" style="text-shadow: none;"><?php echo format::priority_level(2);?></a></li>
                <li><a href="/application/by_filter/?priority=3" style="text-shadow: none;"><?php echo format::priority_level(3);?></a></li>
                <li><a href="/application/by_filter/?priority=4" style="text-shadow: none;"><?php echo format::priority_level(4);?></a></li>
                <li><a href="/application/by_filter/?priority=5" style="text-shadow: none;"><?php echo format::priority_level(5);?></a></li>
            </ul>    
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Payment Status</a>
            <ul class="dropdown-menu">
                <li><a href="/application/by_filter/?payment=1" style="text-shadow: none;"><?php echo format::payment_status(1);?></a></li>
                <li><a href="/application/by_filter/?payment=2" style="text-shadow: none;"><?php echo format::payment_status(2);?></a></li>
            </ul>    
        </li>
    </ul>