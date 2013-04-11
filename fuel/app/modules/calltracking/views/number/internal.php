<h1 class="span16">Internal Numbers</h1>

<div class="span16">

    <div class="row">
        
        <div class="span13">
            <ul class="tabs">
                <li><a href="/calltracking/number/listing/purchased">Purchased</a></li>
                <li class="active"><a href="/calltracking/number/listing/internal">Internal</a></li>
            </ul>
        </div>
        
        <div class="span3">
            <a href="/calltracking/number/add" class="btn success fr">Add a Number</a>    
        </div>    
        
    </div>     
    
    
    
    
    <table class="zebra-striped">
        <thead>
            <tr>
                <th>Label</th>
                <th>Number</th>
                <th>Campaigns</th>
                <th colspan="2"></th>
            </tr>    
        </thead>
        <tbody>
    <?php foreach($numbers as $number):?>   
            <tr>
                <td><?php echo $number['label'];?></td>
                <td><?php echo \format::phone($number['number']);?></td>
                <td></td>
                <td width="25"><a href="/calltracking/number/update/<?php echo $number['id'];?>"><img src="/img/icons/update.png"></a></td>
                <td width="25"><a href="/calltracking/number/delete/<?php echo $number['id'];?>" onclick="return confirm('Are you sure you want to delete this number?')"><img src="/img/icons/delete.png"></a></td>
            </tr>
    <?php endforeach;?>
       </tbody>     
    </table>
    
</div>