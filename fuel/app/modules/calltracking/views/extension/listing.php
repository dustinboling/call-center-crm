<h1 class="span16">Extensions</h1>

<div class="span16">
    
    <table class="zebra-striped">
        <thead>
            <tr>
                <th width="75">Extension</th>
                <th>Name</th>
                <th colspan="2"><a href="/calltracking/extension/add" class="btn success fr">Add</a></th>
            </tr>    
        </thead>
        <tbody>
    <?php foreach($extensions as $e):?>     
            <tr>
                <td><?php echo $e['extension'];?></td>
                <td><?php echo $e['name'];?></td>
                <td width="20"><a href="/calltracking/extension/update/<?php echo $e['id'];?>"><img src="/img/icons/update.png"></a></td>
                <td width="20"><a href="/calltracking/extension/delete/<?php echo $e['id'];?>"><img src="/img/icons/delete.png"></a></td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
    
</div>