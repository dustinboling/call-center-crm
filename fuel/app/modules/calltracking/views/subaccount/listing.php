<h1 class="span16">Sub Accounts</h1>

<div class="span16">
    
    <table class="zebra-striped">
        <thead>
            <tr>
                <th>Account</th>
                <th>Status</th>
                <th colspan="2"><a href="/calltracking/subaccount/add" class="btn success fr">Add</a></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($subaccounts as $s):?>
            <tr>
                <td><?php echo $s['company'];?></td>
                <td><?php ($s['active'] ? print 'Active': print 'Closed');?></td>
                <td width="25"><a href="/calltracking/subaccount/update/<?php echo $s['id'];?>"><img src="/img/icons/update.png"></a></td>
                <td width="25"><a href="/calltracking/subaccount/delete/<?php echo $s['id'];?>" onclick="return confirm('Are you sure you want to delete this Sub Account?')"><img src="/img/icons/delete.png"></a></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>