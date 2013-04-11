<h1 class="span16">Update Sub Account</h1>

<div class="span8">
    
    <form action="/calltracking/subaccount/update/<?php echo $subaccount['id'];?>" method="post" id="form">
        
        <fieldset>
            
            <legend></legend>
            
            <div class="clearfix">
                <label for="email">Email</label>
                <div class="input">
                    <input type="text" name="email">
                </div>
            </div>
            
            <div class="clearfix">
                <label for="passwd">Password</label>
                <div class="input">
                    <input type="text" name="passwd">
                </div>
            </div>
            
            <div class="clearfix">
                <label for="company">Company</label>
                <div class="input">
                    <input type="text" name="company">
                </div>
            </div>
            
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
            
            <div class="actions">
                <button class="btn primary">Save</button>
            </div>
            
        </fieldset>    
        
    </form>
    
</div>    

<script type="text/javascript">
    $(document).ready(function(){
       $("#form").populate(<?php echo json_encode($subaccount);?>); 
    });
</script>