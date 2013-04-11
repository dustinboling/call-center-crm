<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Campaigns</h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped">
    
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Cost Per Lead</th>
            <th colspan="2"></th>
        </tr>    
    </thead>
    
    <tbody>
        <?php foreach($campaigns as $c):?>
        <tr>
            <td width="50"><?php echo $c['id'];?></td>
            <td>
                <?php echo $c['name'];?>
                <?php if(!empty($c['description'])):?>
                <br><small><?php echo $c['description'];?></small>
                <?php endif;?>
            </td>
            <td width="100" class="r"><?php (!empty($c['cost_per_lead'])?print '$'.number_format($c['cost_per_lead'],2):'');?></td>
            <td width="20"><a href="/system/campaign/update/<?php echo $c['id'];?>"><img src="/img/icons/update.png" alt="update"></a></td>
            <td width="20"><a href="/system/campaign/delete/<?php echo $c['id'];?>" onclick="return confirm('Are you sure you want to delete <?php echo $c['name'];?>?');"><img src="/img/icons/delete.png" alt="delete"></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    
</table>

</div>