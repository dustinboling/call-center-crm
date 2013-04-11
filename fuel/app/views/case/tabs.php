<ul class="nav nav-tabs">
    <li class="<?php (uri::segment(2)=='listing' ? print 'active':'');?>"><a href="/case/listing/">Listing</a></li>
    <li class="<?php (uri::segment(2)=='add' ? print 'active':'');?>"><a href="/case/add/">Add</a></li>
    <li class="<?php (uri::segment(2)=='duplicates' ? print 'active':'');?>"><a href="/case/duplicates/">Manage Duplicates</a></li>
</ul>