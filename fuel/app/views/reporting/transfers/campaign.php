<?php echo View::Factory('reporting/menu')->render();?>

<div class="span10">
    
    <h1>Transfers By Campaign <?php if(uri::segment(4)==''){ print 'Today'; }elseif(uri::segment(4) == 'custom'){print $_POST['start']. '-' .$_POST['end']; }else{ print DateRange::describe(uri::segment(4));}?></h1>
    
    <?php echo View::factory('reporting/daterange', array('uri' => '/reporting/transfers/campaign'));?>
    
    <h2>Campaigns</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Transfers</th>
                <th>Campaign</th>
            </tr>
        </thead>
        <?php foreach($campaigns as $c):?>
        <tr>
            <td width="100"><?php echo $c['total'];?></td>
            <td><?php echo $c['name'];?></td>
        </tr>
        <?php endforeach;?>
    </table>
    
</div>