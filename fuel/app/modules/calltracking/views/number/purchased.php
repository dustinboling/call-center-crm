<h1 class="span16">Purchased Numbers</h1>

<div class="span16">
    
    
    <div class="row">
        
        <div class="span12">
            <ul class="tabs">
                <li class="active"><a href="/calltracking/number/listing/purchased">Purchased</a></li>
                <li><a href="/calltracking/number/listing/internal">Internal</a></li>
            </ul>
        </div>
        
        <div class="span4">
            <a href="/calltracking/number/purchase" class="btn success fr">Purchase Additional Numbers</a>
        </div>
        
    </div>    
            
    
    <table class="zebra-striped">
        <thead>
            <tr>
                <th>Number</th>
                <th>Current Campaign</th>
                <th></th>
            </tr>    
        </thead>
        <tbody>
    <?php foreach($numbers as $number):?>
            <tr>
                <td><?php echo format::phone($number['number']);?></td>
                <td>
                    <?php if($number['campaign_id']):?>
                        <a href="/calltracking/campaign/calls/<?php echo $number['campaign_id'];?>"><?php echo $number['campaign'];?></a>
                    <?php else:?>
                        <a href="/calltracking/campaign/add/<?php echo $number['id'];?>">Create Campaign</a>
                    <?php endif;?>
                </td>
                <td></td>
            </tr>       
    <?php endforeach;?>
        </tbody>
    </table>
    
</div>