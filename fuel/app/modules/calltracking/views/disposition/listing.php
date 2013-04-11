<h1 class="span16">Dispositions</h1>

<div class="span-two-thirds">
    
    <table class="zebra-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th colspan="2"></th>
            </tr>    
        </thead>
        <tbody id="disposition_list">
    <?php foreach($dispositions as $disposition):?>
        
            <tr id="disposition_<?php echo $disposition['id'];?>">
                <td class="disposition"><?php echo $disposition['name'];?></td>
                <td width="25"><a href="/calltracking/disposition/update/<?php echo $disposition['id'];?>" class="inline_update"><img src="/img/icons/update.png"></a></td>
                <td width="25"><a href="/calltracking/disposition/delete/<?php echo $disposition['id'];?>" class="inline_delete"><img src="/img/icons/delete.png"></a></td>
            </tr>
        
    <?php endforeach; ?>
        </tbody>    
    </table>
    
</div>

<div class="span-one-third">
    <form class="form-stacked">
        <fieldset>
            <legend>Add a Disposition</legend>
            <div class="clearfix">
                <label for="name">Name</label>
                <div class="input">
                    <input type="text" name="name" id="disposition_name" autocomplete="off">
                </div>    
            </div>  
            <div class="actions">
                <button class="btn primary" id="save_disposition">Save</button>
            </div>    
        </fieldset>
    </form>
</div>    

<script type="text/javascript">
    $(document).ready(function(){
       
       $("#save_disposition").click(function(e){
           name = $("#disposition_name").val();
           if(name.length > 0){
               $.post('/calltracking/disposition/add', {'name': name}, function(data){
                   html = disposition_row_html(data, name);
                   $("#disposition_list").prepend(html);
                   $("#disposition_name").val('');
               });
           }
           e.preventDefault();
       });
       
       $(".inline_update").live('click', function(e){
           href = $(this).attr('href');
           item = $(this).parents('tr').find('.disposition');
           val = item.html();

           as_input = '<div class="input no-margin"><div class="input-append"><input type="text" value="'+val+'" class="fl"><span class="add-on"><a href="'+href+'" class="save_update"><img src="/img/icons/accept.png"></a></span></div></div>';
           
           item.html(as_input);
           e.preventDefault();
       });
       
       $(".inline_delete").live('click', function(e){
          answer = confirm('If you delete this disposition, all calls using it will be reset to the default disposition. Are you sure?');
          if(answer){ 
              var item = $(this);
              $.get($(this).attr('href'), function(data){
                  $(item).parents('tr').remove();
               });
          }
          e.preventDefault();
       });
       
       $(".save_update").live('click', function(e){
           var updated_val = $(this).parents('td').find('input').val();
           var item = $(this);
           $.post($(this).attr('href'), {'name': updated_val}, function(data){
              $(item).parents('td').html(updated_val);
           });
           e.preventDefault();
       });
       
    });
    
    function disposition_row_html(id, name){
        
        html  = '<tr id="disposition_'+id+'">';
        html += '<td class="disposition">'+name+'</td>';
        html += '<td width="25"><a href="/calltracking/disposition/update/'+id+'" class="inline_update"><img src="/img/icons/update.png"></a></td>';
        html += '<td width="25"><a href="/calltracking/disposition/delete/'+id+'" class="inline_delete"><img src="/img/icons/delete.png"></a></td>';
        html += '</tr>'
        
        return html;
        
    }
</script>