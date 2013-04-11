<h1><?php echo $case['first_name'] . ' ' . $case['last_name'];?></h1>

<?php echo $header;?>

<ul class="nav nav-tabs">
    <li><a href="/case/view/<?php echo uri::segment(3);?>/#overview">Overview</a></li>
    <li><a href="/case/update/<?php echo uri::segment(3);?>">Case Info</a></li>
    <li class="dropdown active"><a class="dropdown-toggle" data-toggle="dropdown">Payments <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/payment/process/<?php echo uri::segment(3);?>">Process Next Payment</a>
            <li><a href="/payment/manage/<?php echo uri::segment(3);?>">Payment Plan</a>
        </ul>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">Documents <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/esign/document/listing/<?php echo uri::segment(3);?>">ESign Documents</a>
            <li><a href="/case/view/<?php echo uri::segment(3);?>/#forms">Forms</a>
            <li><a href="/case/view/<?php echo uri::segment(3);?>/#documents">Uploaded Documents</a>
        </ul>
    </li>    
    <li><a href="/case/view/<?php echo uri::segment(3);?>/#activity">Activity</a></li>
</ul>

<h2>Update Payment</h2>

<form action="/payment/update/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>" method="post" id="payment_form">   
    
    <div class="row-fluid">
        
        <div class="span4">
            
            <div class="control-group">
                <label class="control-label">Due Date</label>
                <div class="controls">
                    <input type="text" name="date_due" class="datepicker">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Amount Due</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on">$</span>
                        <input type="text" name="amount">
                    </div>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Status</label>
                <div class="controls">
                    <select name="status">
                        <?php if(!in_array($payment['status'], array('paid','nsf'))):?>
                        <option value="pending">Pending</option>
                        <option value="hold">Hold</option>
                        <?php endif;?>
                        <?php if(!in_array($payment['status'], array('pending'))):?>
                        <option value="processing">Processing</option>
                        <option value="paid">Paid</option>
                        <option value="NSF">NSF</option>
                        <?php endif;?>
                    </select>    
                </div>
            </div>
            
        </div>
        
        <div class="span4">
            
            <div class="control-group">
                <label class="control-label">Amount Received</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on">$</span>
                        <input type="text" name="amount_received">
                    </div>
                </div>
            </div>
            
             <div class="control-group">
                <label class="control-label">Note</label>
                <div class="controls">
                    <input type="text" name="received_note">
                </div>
            </div>
            
        </div>
        
    </div>    
    
    
    
    
    
   

<div class="form-actions">
    <button class="btn btn-primary" type="submit">Update Payment</button>
</div>    
    
</form>

<script type="text/javascript">
$(document).ready(function(){
    
   $("#payment_form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($payment)?json_encode($payment):'')); ?>); 

});
</script>