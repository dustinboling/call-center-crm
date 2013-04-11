<h1 class="span16">Leads</h1>

<div class="span16">

    <table class="zebra-striped">
        <thead>
            <tr>
                <th>Docs</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Campaign</th>
                <th>Rep</th>
                <th>Status</th>
                <th>Last Action</th>
                <th>Liability</th>
                <th colspan="3" style="text-align: center"><a href="/application/add" class="btn success small">Add New</a></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($leads as $l):?>
            <tr>
                <td></td>
                <td><?php echo $l['first_name'];?></td>
                <td><?php echo $l['last_name'];?></td>
                <td><?php echo $l['phone_home'];?></td>
                <td><?php echo $l['rep'];?></td>
                <td><?php echo $l['status'];?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>    