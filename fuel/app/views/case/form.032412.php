<h1><?php echo $case['first_name'] . ' ' . $case['last_name'];?></h1>

<?php echo $header;?>

<ul class="nav nav-tabs">
    <li><a href="/case/view/<?php echo uri::segment(3);?>/#overview">Overview</a></li>
    <li class="active"><a>Case Info</a></li>
    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">Payments <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/payment/process/<?php echo uri::segment(3);?>">Process Next Payment</a>
            <li><a href="/payment/manage/<?php echo uri::segment(3);?>">Payment Plan</a>
        </ul>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">Documents <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/case/view/<?php echo uri::segment(3);?>/#forms">Forms</a>
            <li><a href="/case/view/<?php echo uri::segment(3);?>/#documents">Uploaded Documents</a>
        </ul>
    </li>    
    <li><a href="/case/view/<?php echo uri::segment(3);?>/#activity">Activity</a></li>
</ul>

<?php echo View::factory('case/notes', array('notes' => (isset($case['notes'])?$case['notes']:'')))->render();?>

<ul class="nav nav-pills">
    <?php foreach($fields as $section_id => $cfs):?>
        <li<?php if($section_id == 1):?> class="active"<?php endif;?>><a data-toggle="tab" data-target="#section<?php echo $section_id;?>" href="#section<?php echo $section_id;?>"><?php (isset($fgroups[$section_id]['name'])? print $fgroups[$section_id]['name']:'');?></a></li>
    <?php endforeach;?>
</ul>

<form action="/case/update/<?php echo uri::segment(3);?>" method="post" class="form" id="form">
    <?php echo View::factory('case/fields', array('fields' => $fields, 'fgroups' => $fgroups, 'options' => $options))->render();?>
<?php /*
<div class="tab-content">
    
    <?php foreach($fields as $section_id => $cfs):?>
        <div class="fields-section tab-pane<?php if($section_id == 1):?> active<?php endif;?>" id="section<?php echo $section_id;?>">
        <h2><?php (isset($fgroups[$section_id]['name'])? print $fgroups[$section_id]['name']:'');?></h2>

        <?php foreach($cfs as $container_id => $fs):?>

            <div class="fields-container">

            <h3><?php (isset($fgroups[$container_id]['name'])? print $fgroups[$container_id]['name']:'');?></h3>
            <?php $cf_split = ceil(count($fs)/3); $cl = 1; ?>

            <?php if(empty($fgroups[$container_id]['template'])):?>
            <div class="span3">    
            <?php foreach($fs as $f):?>
                <?php if($f['editable']):?>
                    <?php if($cf_split < $cl):?>    
                    <?php if($cl != 1):?><div class="clear"></div></div><?php endif;?>    
                    <div class="span3">
                    <?php $cl = 1; ?>    
                    <?php endif;?>

                    <div class="control-group">
                        <label class="control-label" for="<?php echo $f['clean_name'];?>"><?php echo $f['name'];?></label>
                        <div class="controls">
                            <?php if($f['field_type_id'] == 7):?>
                            <input type="text" name="<?php echo $f['clean_name'];?>" class="datepicker" placeholder="mm/dd/yyyy">
                            <?php elseif($f['field_type_id'] == 16):?>
                            <select name="<?php echo $f['clean_name'];?>">
                                <option value=""></option>
                                <?php if(isset($options[$f['id']])):?>
                                    <?php foreach($options[$f['id']] as $k => $v):?>
                                        <option value="<?php echo $v;?>"><?php echo $v;?></option>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </select>
                            <?php elseif($f['field_type_id'] == 6):?>
                            <div class="input-prepend">
                                <span class="add-on">$</span>
                                <input type="text" name="<?php echo $f['clean_name'];?>">
                            </div>
                            <?php else:?>
                            <input type="text" name="<?php echo $f['clean_name'];?>">
                            <?php endif;?>
                        </div>
                    </div>

                    <?php $cl++; ?>   
                <?php endif;?>
            <?php endforeach;?>
            
            <div class="clear"></div>  

            </div>
                        
            <?php else:?>
                <?php echo $fgroups[$container_id]['template'];?>
            <?php endif;?>
              

            <div class="clear"></div>

            </div>
        <?php endforeach;?>

        <div class="clear"></div>    

       <div class="form-actions">
            <button class="btn btn-primary">Save</button>
        </div>

        </div>

    <?php endforeach;?>  
    
</div>    
*/?>    
</form>    

<?php 
    
    function prepop($case, $field){
        
        if(isset($_POST[$field])){
            return $_POST[$field];
        }elseif(isset($case[$field])){
            return $case[$field];
        }
        
        return '';
    }

    $taxes = array(
                    'federal_owed' => prepop($case, 'federal_owed'),
                    'federal_not_filed' => prepop($case, 'federal_not_filed'),
                    'state_owed' => prepop($case, 'state_owed'),
                    'state_not_filed' => prepop($case, 'state_not_filed')
                  );
    
    if(isset($case['federal_owed'])){ unset($case['federal_owed']); }
    if(isset($case['federal_not_filed'])){ unset($case['federal_not_filed']); }
    if(isset($case['state_owed'])){ unset($case['state_owed']); }
    if(isset($case['state_not_filed'])){ unset($case['state_not_filed']); }
    
?>

<script type="text/javascript">
$(function(){
    $("#form").populate(<?php echo (!empty($_POST)?json_encode($_POST):(isset($case)?json_encode($case):'')); ?>);
    
    <?php foreach($taxes as $field => $values):?>
        var <?php echo $field;?> = <?php echo json_encode($values);?>;
    
        for(i in <?php echo $field;?>){
            $('input[name="<?php echo $field;?>[]"][value="'+<?php echo $field;?>[i]+'"]').prop("checked", true);
        };  

    <?php endforeach;?>
    
});
</script>