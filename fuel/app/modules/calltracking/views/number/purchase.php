<h1 class="span16">Purchase Additional Numbers</h1>

<div class="span8">
    
    <form>
        <fieldset>
            <legend>Find Numbers</legend>

            <div class="clearfix">
                <label for="type">Number Type</label>
                <div class="input">
                    <select name="type" id="type">
                        <option value="local">Local</option>
                        <option value="tollfree">Toll Free</option>
                    </select>    
                </div>
            </div>    

            <div class="clearfix" id="state_container">
                <label for="state">State</label>
                <div class="input">
                    <select name="state" id="state">
                        <?php foreach($states as $k => $v):?>
                        <option value="<?php echo $k;?>"><?php echo $v;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="clearfix" id="area_code_container">
                <label for="area_code">Area Code</label>
                <div class="input">
                    <select name="area_code" id="area_code">

                    </select>
                </div>
            </div>
            
            <div class="clearfix" id="toll_free_container">
                <label for="type">Type</label>
                <div class="input">
                    <select id="toll_free_type">
                        <option value=""></option>
                        <option value="888">888</option>
                        <option value="877">877</option>
                        <option value="866">866</option>
                        <option value="800">800</option>
                    </select>
                </div>    
            </div>
            
        </fieldset>
    </form>

    
</div>

<div class="span8">
    
    &nbsp;
    
</div>    

<div class="clear"></div>

<div class="span8">
        
    <h3>Available Numbers</h3>
    
    <ul id="available_numbers" class="unstyled">
        
    </ul>
    
</div>

<div class="span8">
    
    <h3>Selected Numbers</h3>
    <ul id="selected_numbers" class="unstyled">
        
    </ul>
    <div class="clear"></div>
    <div class="actions">
        <button class="btn primary" type="submit" id="purchase" disabled="disabled">Purchase Numbers</button>
        <button class="btn" id="remove_all">Remove All</button>
    </div>
    
</div>

<form id="purchase_numbers" action="/calltracking/number/purchase" method="post"></form>

<div class="clear"></div>

<script type="text/javascript">
    
    $(document).ready(function(){
       
       $("#type").change(function(e){
          v = $(this).val();
          $("#area_code_container").hide();
          $("#state_container").hide();
          $("#toll_free_container").hide();
          if(v == 'local'){
              $("#area_code_container").show();
              $("#state_container").show();
          }else if(v == 'tollfree'){
              $("#toll_free_container").show();
          }
       });
       
       $("#state").change(function(e){
           state = $(this).val();
           $("#area_code").html('');
           if(state.length > 0){
               $.getJSON('/calltracking/iapi/area_codes/'+state, function(data){
                   $("#area_code").html('<option>Select One</option>');
                   $.each(data, function(k, v) {
                       $("#area_code").append('<option value="'+v+'">'+v+'</option>');
                   });
               });
           }
       });
       
       $("#area_code").change(function(e){
           area_code = $(this).val();
           $("#available_numbers").html('');
           if(area_code.length > 0){
                $.getJSON('/calltracking/iapi/local_numbers/'+area_code, function(data){
                    if(data.length == 0){
                        $("#available_numbers").append('<li>No numbers currently available for '+area_code+'</li>');
                    }else{
                        $.each(data, function(k, v) { 
                            $("#available_numbers").append('<li class="available_number" id="'+v.clean+'"><a href="#" class="btn select_number">'+v.formatted+'</a></li>'); 
                        });
                    }
                });
           }
       });
       
       $("#toll_free_type").change(function(e){
           area_code = $(this).val();
           $("#available_numbers").html('');
           if(area_code.length > 0){
                $.getJSON('/calltracking/iapi/toll_free_numbers/'+area_code, function(data){
                    if(data.length == 0){
                        $("#available_numbers").append('<li>No numbers currently available for '+area_code+'</li>');
                    }else{
                        $.each(data, function(k, v) { 
                            $("#available_numbers").append('<li class="available_number" id="'+v.clean+'"><a href="#" class="btn select_number">'+v.formatted+'</a></li>'); 
                        });
                    }
                });
           }
       });
       
       $(".available_number").live('click', function(e){
           select_number($(this));
           e.preventDefault();
       });
       
       $(".selected_number").live('click', function(e){
           remove_number($(this));
           e.preventDefault();
       });
       
       $("#remove_all").click(function(e){
          $.each($(".selected_number"), function(i,elem){
              remove_number($(elem));
          });
       });
       
       $("#purchase").click(function(e){
           number_count = $("#purchase_numbers").children('input').length;
           
           answer = confirm('You are about to purchase '+number_count+ ' number(s). Continue?');
           
           if(answer){
               $("#purchase_numbers").submit();
           }
           
           e.preventDefault();
       });
       
    });
    
    function select_number(obj){
        $(obj).children('a').addClass('success');
        $(obj).removeClass('available_number').addClass('selected_number').appendTo("#selected_numbers");
        $("#purchase_numbers").append('<input type="hidden" name="numbers[]" value="'+$(obj).children('a').html()+'">');
        manage_purchase_state();
    }
    
    function remove_number(obj){
        $(obj).children('a').removeClass('success');
        $(obj).removeClass('selected_number').addClass('available_number').appendTo("#available_numbers");
        $("#purchase_numbers").find('input[value="'+$(obj).children('a').html()+'"]').remove();
        manage_purchase_state();
    }
    
    function manage_purchase_state(){
        if($(".selected_number").length > 0){
            $("#purchase").removeAttr('disabled');
            $("#remove_all").removeAttr('disabled');
        }else{
            $("#purchase").attr('disabled', 'disabled');
            $("#remove_all").attr('disabled', 'disabled');
        }
    }
    
</script>    