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