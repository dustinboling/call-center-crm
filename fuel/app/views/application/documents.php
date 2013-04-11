<?php echo View::factory('application/notes', $notes)->render();?>

<div class="row-fluid">
<div class="span9">
    
    <h1>Documents</h1>

    <?php echo View::factory('application/app_edit_tabs', $tabs)->render(); ?>


    <p><span class="label notice">Note</span> <strong>Drag &amp; drop files in this window to upload</strong> <span id="message" class="label"></span></p>

    <table class=" table table-striped" id="file_list">
        <thead>
            <tr>
                <th>File</th>
                <th>Added</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($documents as $d):?>
        <tr>
            <td><a href="/document/view/<?php echo $d['id'];?>" target="_blank"><?php echo $d['name'];?></a></td>
            <td><?php echo format::relative_date($d['created_date']);?></td>
            <?php /*<td width="20" class="c"><a href="/application/document_update/<?php echo $d['id'];?>"><img src="/img/icons/update.png"></a></td>*/?>
            <td width="20" class="c"><a href="/document/delete/<?php echo $d['id'];?>" onclick="double_check();"><img src="/img/icons/delete.png"></a></td>
        </tr>    
        <?php endforeach;?>
        </tbody>
    </table>   

</div>
</div>

<input id="fileupload" type="file" name="files[]" multiple style="display: none;">
<script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/js/jquery.fileupload.js"></script>

<script type="text/javascript">
$(function () {
    $('#fileupload').fileupload({
        dataType: 'json',
        url: '/application/upload_document/<?php echo uri::segment(3);?>',
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                $("#file_list tbody").prepend('<tr><td><a href="/document/view/'+file.id+'">'+file.name+'</a></td><td>'+file.created_date+'</td><td width="20" class="c"><a href="/document/delete/'+file.id+'" onclick="double_check()"><img src="/img/icons/delete.png"></a></td></tr>');
            });
        },
        acceptFileTypes : /\.txt$/i
    }).bind('fileuploadsend', function(e, data){ $("#message").html('Uploading file...').addClass('notice')})
    .bind('fileuploaddone', function (e, data) {$("#message").html('File uploaded!').removeClass('notice').addClass('success')});
});

function double_check(){
    return confirm('Are you sure you want to delete this document?');
}
</script>