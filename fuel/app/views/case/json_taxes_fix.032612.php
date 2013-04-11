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
    <?php foreach($taxes as $field => $values):?>
        var <?php echo $field;?> = <?php echo json_encode($values);?>;
    
        for(i in <?php echo $field;?>){
            $('input[name="<?php echo $field;?>[]"][value="'+<?php echo $field;?>[i]+'"]').prop("checked", true);
        };  

    <?php endforeach;?>
});
</script>