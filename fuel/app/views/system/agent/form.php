<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1><?php echo ucwords(uri::segment(3));?> an Agent</h1>

<?php echo View::Factory('system/tabs')->render();?>

<form action="/system/agent/<?php echo uri::segment(3);?>/<?php echo uri::segment(4);?>" method="post" id="form">
    
    <fieldset>
        
        <div class="clearfix">
            <label for="first_name">First Name</label>
            <div class="input">
                <input type="text" name="first_name">
            </div>
        </div>    

        <div class="clearfix">
            <label for="last_name">Last Name</label>
            <div class="input">
                <input type="text" name="last_name">
            </div>
        </div> 

        <div class="clearfix">
            <label for="type">Type</label>
            <div class="input">
                <select name="type">
                    <option value=""></option>
                    <option value="Accountant">Accountant</option>
                    <option value="Attorney">Attorney</option>
                    <option value="CPA">CPA</option>
                    <option value="Enrolled Agent">Enrolled Agent</option>
                    <option value="Tax Preparer">Tax Preparer</option>
                </select>    
            </div>
        </div> 

        <div class="clearfix">
            <label for="email">Email</label>
            <div class="input">
                <input type="text" name="email">
            </div>
        </div> 

        <div class="clearfix">
            <label for="phone">Phone</label>
            <div class="input">
                <input type="text" name="phone">
            </div>
        </div> 
        
        <div class="clearfix">
            <label for="ext">Extension</label>
            <div class="input">
                <input type="text" name="ext">
            </div>
        </div> 
        
        <div class="clearfix">
            <label for="direct_phone">Direct Phone</label>
            <div class="input">
                <input type="text" name="direct_phone">
            </div>
        </div> 
        
        <div class="clearfix">
            <label for="fax">Fax</label>
            <div class="input">
                <input type="text" name="fax">
            </div>
        </div> 
        
        <div class="clearfix">
            <label for="address">Address</label>
            <div class="input">
                <input type="text" name="address">
            </div>
        </div> 
        
        <div class="clearfix">
            <label for="caf">CAF</label>
            <div class="input">
                <input type="text" name="caf">
            </div>
        </div> 
        
        <div class="clearfix">
            <label for="state_jurisdition">State Jurisdiction</label>
            <div class="input">
                <select name="state_jurisdiction">
                    <option value=""></option>
                    <option value="CA">CA</option>
                </select>
            </div>
        </div> 
        
        
        <div class="clearfix">
            <label for="license_number">License Number</label>
            <div class="input">
                <input type="text" name="license_number">
            </div>
        </div> 
        
        <div class="clearfix">
            <label for="f2848_designation">F2848 Designation</label>
            <div class="input">
                <input type="text" name="f2848_designation">
            </div>
        </div> 
        
        <div class="actions">
            <button class="btn primary">Save</button>
        </div>
        
    </fieldset>
    
</form>

<script type="text/javascript">
$(document).ready(function(){
   $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($row)?json_encode($row):'')); ?>); 
});
</script>