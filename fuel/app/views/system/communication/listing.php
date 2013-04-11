<?php echo View::Factory('system/menu')->render();?>

<div class="span9">

<h1>Communications</h1>

<?php echo View::Factory('system/tabs')->render();?>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Communication</th>
        <th>Email</th>
        <th>SMS</th>
        <th>Call</th>
        <th colspan="2"></th>
    </tr>
    </thead>
    <?php foreach($communications as $c):?>
    <tr>
        <td><?php echo $c['name'];?></td>
        <td class="c"><?php if(!empty($c['template_email_id'])):?><img src="/img/icons/accept.png"><?php endif;?></td>
        <td class="c"><?php if(!empty($c['template_sms_id'])):?><img src="/img/icons/accept.png"><?php endif;?></td>
        <td class="c"><?php if(!empty($c['template_call_id'])):?><img src="/img/icons/accept.png"><?php endif;?></td>
        <td class="c" width="20"><a href="/system/communication/update/<?php echo $c['id'];?>"><img src="/img/icons/update.png"></a></td>
        <td class="c" width="20"><a href="/system/communication/delete/<?php echo $c['id'];?>"><img src="/img/icons/delete.png"></a></td>
    </tr>
    <?php endforeach;?>
</table>    