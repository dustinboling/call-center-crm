<h1 class="span16">Campaigns</h1>

<div class="span16">
    
    <ul class="tabs">
        <li class="active"><a href="/calltracking/campaign/listing">Campaign List</a></li>
        <li><a href="/calltracking/call/by_date/today">Today's Calls</a></li>
    </ul>
    
    <?php echo $filter_bar;?>
    
    <table class="zebra-striped">
        <thead>
            <tr>
                <th>Campaign</th>
                <th>Incoming Number</th>
                <th>Forwarding Number</th>
                <th>Sub Account</th>
                <th colspan="2"><a href="/calltracking/campaign/add" class="btn success fr">Add</a></th>
            </tr>    
        </thead>
        <tbody>
    <?php foreach($campaigns as $campaign):?>     
            <tr>
                <td><?php echo $campaign['name'];?></td>
                <td width="150"><?php echo format::phone($campaign['incoming_number']);?></td>
                <td width="150"><?php echo format::phone($campaign['forwarding_number']);?></td>
                <td><?php echo $campaign['subaccount'];?></td>
                <td width="20"><a href="/calltracking/campaign/update/<?php echo $campaign['id'];?>"><img src="/img/icons/update.png"></a></td>
                <td width="20"><a href="/calltracking/campaign/calls/<?php echo $campaign['id'];?>"><img src="/img/icons/phone.png"></a></td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
    
</div>