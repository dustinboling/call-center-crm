<ul class="nav nav-tabs">
    <li class="<?php (uri::segment(2) == 'day'? print 'active':'');?>"><a href="/calendar/day">Day</a></li>
    <li class="<?php (uri::segment(2) == 'week'? print 'active':'');?>"><a href="/calendar/week">Week</a></li>
    <li class="<?php (uri::segment(2) == 'month'? print 'active':'');?>"><a href="/calendar/month">Month</a></li>
    <li><a href="/event/add">Add an Event</a></li>
</ul>