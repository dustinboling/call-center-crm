<h1>Prepare <?php echo $form['name'];?></h1>

<h2 style="margin-bottom: 15px;"><a href="/case/view/<?php echo $case['id'];?>"><?php echo $case['id'];?></a> - <?php echo $case['first_name']. ' ' . $case['last_name'];?></h2>

<p><a href="/esign/document/listing/<?php echo uri::segment(4);?>" class="btn">Back to listing</a></p>

<form action="" method="post" class="form form-horizontal">
<?php echo $fields;?>
    <div class="form-actions">
        <input class="btn btn-info" type="submit" name="prepare" value="Preview">
        <input class="btn btn-primary" type="submit" name="prepare" value="Send">
    </div>    
</form>    

