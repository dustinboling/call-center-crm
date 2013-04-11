<h1>Appointments</h1>

    <ul class="nav nav-pills">
        <li class="<?php (uri::segment(2) == 'listing'? print 'active':'');?>"><a href="/event/listing">All My Appointments</a></li>
        <li class="<?php (uri::segment(2) == 'by_date'? print 'active':'');?>"><a href="/event/by_date/<?php echo date('Y-m-d');?>">Today</a></li>
        <li class="<?php (uri::segment(3) == 'overdue'? print 'active':'');?>"><a href="/event/by_status/overdue">Overdue</a></li>
    </ul>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="100">Appointment At</th>
            <th width="100">Status</th>
            <th width="100">Case ID</th>
            <th>Title</th>
            <th></th>
        </tr>
    </thead>
    <?php foreach($events as $e):?>
    <tr>
        <td><?php echo date('m/d g:ia', strtotime($e['at']));?></td>
        <td>
            <?php if(!empty($e['completed'])):?>
                <span class="label label-success">Completed</span>
            <?php elseif(time() > strtotime($e['at'])):?>
                <span class="label label-important">Overdue</span>
            <?php elseif(time() < strtotime($e['at'])):?>
                <span class="label label-info">Scheduled</span>
            <?php endif;?>
        </td>
        <td><a href="/case/view/<?php echo $e['case_id'];?>"><?php echo $e['case_id'];?></a></td>
        <td><?php echo $e['title'];?></td>
        <td width="20">
            <?php if(empty($e['completed'])):?>
            <a href="/event/complete/<?php echo $e['id'];?>"><img src="/img/icons/accept.png" alt="complete" onclick="return confirm('Are you sure you want to complete <?php echo $e['title'];?>?');"></a>
            <?php endif;?>
        </td>
        <td width="20"><a href="/event/update/<?php echo $e['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
        <td width="20"><a href="/event/delete/<?php echo $e['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $e['title'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
    </tr>
    <?php endforeach;?>
</table>

<?php if(isset($pagination)):?>
<?php echo View::factory('pagination', $pagination)->render();?>
<?php endif;?>