<?php echo View::Factory('reporting/menu')->render();?>

<div class="span10">
    
    <h1>Transfers By User <?php if(uri::segment(4)==''){ print 'Today'; }elseif(uri::segment(4) == 'custom'){print $_POST['start']. '-' .$_POST['end']; }else{ print DateRange::describe(uri::segment(4));}?></h1>
    
    <?php echo View::factory('reporting/daterange', array('uri' => '/reporting/transfers/user'));?>
    
    <h2>Agents</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Transfers</th>
                <th>Agent</th>
            </tr>
        </thead>
        <?php foreach($agents as $a):?>
        <tr>
            <td width="100"><?php echo $a['total'];?></td>
            <td><?php echo $a['name'];?></td>
        </tr>
        <?php endforeach;?>
    </table>

    <h2>Sales Reps</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Transfers</th>
                <th>Sales Rep</th>
            </tr>
        </thead>
        <?php foreach($reps as $r):?>
        <tr>
            <td width="100"><?php echo $r['total'];?></td>
            <td><?php echo (!empty($r['name'])?$r['name']:'Unassigned');?></td>
        </tr>
        <?php endforeach;?>
    </table>
    
</div>