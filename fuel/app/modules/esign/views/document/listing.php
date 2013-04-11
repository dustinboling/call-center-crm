<h1 class="span12">eSign Documents</h1>

<h2 style="margin-bottom: 15px;"><a href="/case/view/<?php echo $case['id'];?>"><?php echo $case['id'];?></a> - <?php echo $case['first_name']. ' ' . $case['last_name'];?></h2>

<div class="clear"></div>

<div class="row">

    <div class="span3">

        <table class="table table-bordered table-striped">
            <tr>
                <th colspan="2">Form</th>
            </tr>
            <?php foreach($forms as $f):?>
            <tr>
                <td><?php echo $f['name'];?></td>
                <td><a href="/esign/document/prepare/<?php echo uri::segment(4);?>/<?php echo $f['id'];?>" class="btn">Prepare</a></td>
            </tr>
            <?php endforeach;?>
        </table>

    </div>
    
    <div class="span8">
        
        <table class="table table-bordered table-striped">
            <tr>
                <th>Sent</th>
                <th>Form</th>
                <th>Status</th>
                <th>Last Action</th>
                <th colspan="2"></th>
            </tr>
            <?php foreach($documents as $d):?>
            <tr>
                <td><?php echo format::relative_date($d['created']);?></td>
                <td><?php echo $d['form_name'];?></td>
                <td><?php echo $d['status'];?></td>
                <td><?php echo $d['last_action'];?></td>
                <td>
                    <?php if($d['status'] == 'Signed'):?>
                    <a href="/esign/document/download/<?php echo $d['document_key'];?>">Download</a>
                    <?php endif;?>
                </td>
            </tr>
            <?php endforeach;?>
        </table>    
        
    </div>
    
</div>    