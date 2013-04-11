<div class="span16"><h1>Update Extension</h1></div>

<form action="/calltracking/extension/update/<?php echo $extension['id'];?>" method="post" id="form">

<div class="span8">
            
        <fieldset>
            
            <div class="clearfix">
                <label for="name">Name</label>
                <div class="input">
                    <input type="text" name="name">
                </div>
            </div>
            
            <div class="clearfix">
                <label for="name">Extension</label>
                <div class="input">
                    <input type="text" name="extension">
                </div>
            </div>
            
            <div class="actions">
                <button class="btn primary" type="submit">Save</button>
            </div>
            
        </fieldset>    
    
</div>
    
<script type="text/javascript">
    $(document).ready(function(){
       $("#form").populate(<?php echo json_encode($extension);?>); 
    });
</script>