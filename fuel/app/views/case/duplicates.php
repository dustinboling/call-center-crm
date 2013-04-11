<h1>Duplicate Cases</h1>

<?php echo View::factory('case/tabs')->render();?>

<table class="table table-striped">
    
    <thead>
        <tr>
            <th>Created</th>
            <th>Status</th>
            <th>User</th>
            <th>Campaign</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Primary Phone</th>
            <th>Duplicates</th>
        </tr>    
    </thead>
    
    <tbody>
        <?php foreach($cases as $c):?>
        
            <tr>
                <td><?php echo format::relative_date($c['created']);?></td>
                <td><?php echo $c['status'];?></td>
                <td><?php echo (isset($c['sales_rep_name']) ? $c['sales_rep_name'] : '');?></td>
                <td><?php echo $c['campaign'];?></td>
                <td><?php echo $c['first_name'];?></td>
                <td><?php echo $c['last_name'];?></td>
                <td><?php echo format::phone($c['primary_phone']);?></td>
                <td><?php echo count($c['duplicates']);?></td>
            </tr>    
        
        <?php endforeach; ?>
    </tbody>
    
</table>    
