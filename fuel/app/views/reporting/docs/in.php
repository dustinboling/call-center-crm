<?php echo View::Factory('reporting/menu')->render();?>

<div class="span10">
    
    <h1>Docs In <?php if(uri::segment(4)==''){ print 'Today'; }elseif(uri::segment(4) == 'custom'){print $_POST['start']. '-' .$_POST['end']; }else{ print DateRange::describe(uri::segment(4));}?></h1>
    
    <?php echo View::factory('reporting/daterange', array('uri' => '/reporting/docs/in'));?>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="100">Total</th>
                <th>Action</th>
            </tr>
        </thead>
    <?php foreach($docs as $d):?>
        <tr>
            <td><?php echo $d['total'];?></td>
            <td><?php echo $d['action'];?></td>
        </tr>
    <?php endforeach;?>
    </table>
    
</div>