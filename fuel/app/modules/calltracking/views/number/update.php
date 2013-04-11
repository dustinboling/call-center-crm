<h1 class="grid_24">Update Number</h1>

<div class="grid_12">
    
    <form action="/calltracking/number/update/<?php echo Uri::segment(4);?>" method="post" id="form">

        <fieldset>

            <legend></legend>

            <div class="clearfix">
                <label for="label">Label</label>
                <div class="input">
                    <input type="text" name="label">
                </div>
            </div>

            <div class="clearfix">
                <label for="number">Number</label>
                <div class="input">
                    <input type="text" name="number" disabled="disabled">
                </div>
            </div>
            
            <div class="actions">
                <button class="btn primary" type="submit">Save</button>
            </div>     

        </fieldset>

    </form>
    
</div>

<script type="text/javascript">
    $(document).ready(function(){
       $("#form").populate(<?php echo json_encode($number);?>); 
    });
</script>