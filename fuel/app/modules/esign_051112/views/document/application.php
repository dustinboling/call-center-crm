<h1 class="span16">eSign Documents</h1>

<div class="span16"><?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?></div>
<div class="clear"></div>

<div class="span16">
    
    <table class="zebra-striped">
        <tr>
            <th>Form</th>
        </tr>
        <?php foreach($forms as $form):?>
        <tr>
            <td><?php echo $form['name'];?></td>
        </tr>
        <?php endforeach;?>
    </table>
    
</div>