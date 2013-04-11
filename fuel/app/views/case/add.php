<h1>Add a Case</h1>

<?php echo View::factory('case/tabs')->render();?>

<ul class="nav nav-pills">
    <?php foreach($fields as $section_id => $cfs):?>
        <li<?php if($section_id == 1):?> class="active"<?php endif;?>><a data-toggle="tab" data-target="#section<?php echo $section_id;?>" href="#section<?php echo $section_id;?>"><?php (isset($fgroups[$section_id]['name'])? print $fgroups[$section_id]['name']:'');?></a></li>
    <?php endforeach;?>
</ul>

<form action="/case/add" method="post" class="form" id="form">
    <?php echo View::factory('case/fields', array('fields' => $fields, 'fgroups' => $fgroups))->render();?>
</form>

<script type="text/javascript">
$(function(){
    $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):''); ?>);
});
</script>