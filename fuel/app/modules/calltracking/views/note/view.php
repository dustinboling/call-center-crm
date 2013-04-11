<table class="zebra-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Note</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="note_list">
        <?php foreach($notes as $note):?>
        <tr>
            <td width="150" class="date"><?php echo \format::relative_date($note['created']);?></td>
            <td class="note"><?php echo $note['note'];?></td>
            <td width="25"><a href="/calltracking/note/delete/<?php echo $note['id'];?>" class="inline_delete"><img src="/img/icons/delete.png"></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>

<form class="form-stacked">
    <input type="hidden" id="call_id" value="<?php echo \uri::segment(4);?>">
    <fieldset>
        <legend>Add a Note</legend>
        <div class="clearfix">
            <label for="note">Note</label>
            <div class="input">
                <textarea id="note" name="note" class="xxlarge"></textarea>
            </div>
        </div>
        <div class="actions">
            <button class="btn primary" id="save_note">Save</button>
        </div>    
    </fieldset>
</form>

<script type="text/javascript">
    $(document).ready(function(){
       
       $("#save_note").click(function(e){
           note = $("#note").val();
           call_id = $("#call_id").val();
           $.post('/calltracking/note/add', {'note': note, 'call_id': call_id}, function(data){
               console.log(data);
               html = note_row_html(data.id, data.date, note);
               $("#note_list").append(html);
               $("#note").val('');
           }, 'json');

           e.preventDefault();
       });

       $(".inline_delete").live('click', function(e){
          answer = confirm('Sure?');
          if(answer){ 
              var item = $(this);
              $.get($(this).attr('href'), function(data){
                  $(item).parents('tr').remove();
               });
          }
          e.preventDefault();
       });
       
    });
    
    function note_row_html(id, date, note){
        
        html  = '<tr id="note_'+id+'">';
        html += '<td class="date">'+date+'</td>';
        html += '<td class="note">'+note+'</td>';
        html += '<td width="25"><a href="/calltracking/note/delete/'+id+'" class="inline_delete"><img src="/img/icons/delete.png"></a></td>';
        html += '</tr>'
        
        return html;
        
    }
</script>