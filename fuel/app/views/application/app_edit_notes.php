<style>
#note_panel_button {
    outline: 0;
    text-decoration: none;
    width:175px;
    margin: 0 auto 20px auto;
    display:block;
    text-align: center;
    font-weight:bold;
    padding-top:5px;
    padding-bottom:5px;
    background-color:#f5f5f5;
    border-radius: 0 0 5px 5px;
    border-top: 1px solid #fff;
    border-left: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    border-right: 1px solid #ccc;
    -moz-border-radius: 0 0 5px 5px;
    -webkit-border-radius: 0 0 5px 5px;
    -o-border-radius: 0 0 5px 5px;
    -moz-box-shadow: 1px 1px 2px #ebebeb;
    -webkit-box-shadow: 1px 1px 2px #ebebeb;
    box-shadow: 1px 1px 2px #ebebeb;
}
#note_panel {
    background-color: #f5f5f5;
    display:none;
    border-radius: 0 0 5px 5px;
    -moz-border-radius: 0 0 5px 5px;
    -webkit-border-radius: 0 0 5px 5px;
    -o-border-radius: 0 0 5px 5px;
    border-left:1px solid #ccc;
    border-right:1px solid #ccc;
    border-bottom:1px solid #ccc;
}
.note_view {
    width:60%;
    height:300px;
    float:left;
}
.notes {
    border-radius: 0 0 5px 5px;
    -moz-border-radius: 0 0 5px 5px;
    -webkit-border-radius: 0 0 5px 5px;
    -o-border-radius: 0 0 5px 5px;
    border-left:1px solid #ebebeb;
    border-bottom:1px solid #ebebeb;
    border-right:1px solid #ebebeb;
    padding:10px;
    margin-left:10px;
    background-color:#fff;
    width:95%;
    height:250px;
    overflow-y:scroll;
}
.note {
    margin-bottom:10px;
    padding-bottom:10px;
    border-bottom:1px solid #ebebeb;
}
.note_title {
    font-weight:bold;
    font-size:14px;
    margin-bottom:5px;
}
.note_title a {
    text-decoration:none;
    color:black;
}
.note_title a:hover {
    text-decoration:none;
    color:black;
}
.note_created {
    font-size:11px;
    color:#666;
}
.manage_collapse{
    outline: 0;
    border: 0;
    margin-left:10px;
    margin-top:7px;
    display:block;
    width:200px;
    color:#999;
    text-decoration: none;
}
.manage_collapse:hover {
    color:#999;
    text-decoration: none;
}
.note_add {
    width:40%;
    height:300px;
    float:left;
}
.note_form {
    padding:10px;
}
.note_form h3 {
    margin-top:0;
}
</style>
<div id="note_panel">
    <div class="note_view">
        <div class="notes"></div>
        <a href="#" class="manage_collapse" title="Collapse Notes">
            <img src="/img/icons/delete.png"/> Collapse and Expand Notes
        </a>
    </div>

    <div class="note_add">

        <div class="note_form form-stacked">
            <h3>Add a Note:</h3>
            <div class="clearfix">
                <label>Note Summary:</label>
                <div class="input">
                    <input type="text" id="note_summary" style="width:95%">
                </div>
            </div>
            <div class="clearfix">
                <label>Note:</label>
                <div class="input">
                    <textarea id="note_input" style="width:95%; height:100px;"></textarea>
                </div>
            </div>
            <a href="#" class="btn note_add_button">Add Note</a>
        </div>

    </div>

    <div class="clear"></div>

</div>

<a href="#" id="note_panel_button">Notes (<span id="total_note_count">0</span>)</a>

<script type="text/javascript">
$(document).ready(function(){
    set_notes();
    $(".local_collapse").live('click', function(e){
        e.preventDefault();
        $(this).parent().next('div').slideToggle('slow');
    });
    $(".manage_collapse").live('click', function(e){
        e.preventDefault();
        var title= $(this).attr('title');
        if (title == 'Collapse Notes') {
            $(this).attr('title', 'Expand Notes');
            $(this).children('img').attr('src', '/img/icons/add.png');
            $(".note_desc").slideUp('slow');
        } else {
            $(this).attr('title', 'Collapse Notes');
            $(this).children('img').attr('src', '/img/icons/delete.png');
            $(".note_desc").slideDown('slow');
        }
    });
    $("#note_panel_button").click(function(e){
        e.preventDefault();
        $("#note_panel").slideToggle('slow');
    });
    $(".note_add_button").click(function(e){
        e.preventDefault();
        //TODO : add ajax call that adds the note
        if ($("#note_summary").val().length && $("#note_input").val().length) {
            var note = new Object();
            note.title = $("#note_summary").val();
            note.note = $("#note_input").val();
            note.first_name = 'Set by';
            note.last_name = 'you';
            note.created = 'a few seconds ago';
            var json_note = JSON.stringify(note);

            $.post('/application/add_note/<?php echo Uri::segment(3); ?>', { json_note: json_note }, function(data) {
                if (data != 'false') {
                    $(".notes").prepend(set_note(note));
                    $("#total_note_count").html((parseInt($("#total_note_count").html()) + 1));
                    $("#note_summary").val('');
                    $("#note_input").val('');
                    $(".notes").scrollTop(0);
                }
            });
        } else {
            alert('You must add a summary title and a note');
        }
    });
    function set_notes(){
        $(".notes").html('');
        $.get('/application/notes/<?php echo Uri::segment(3); ?>', function(data) {
            if (data != 'false') {
                var notes = JSON.parse(data);
                $("#total_note_count").html(notes.length);
                $.each(notes, function(i, v) {
                    $(".notes").append(set_note(v));
                });
            }
        });
    }
    function set_note(note) {
        var h = '<div class="note"><div class="note_title"><a href="#" class="local_collapse">'+note.title+'</a></div>';
        h = h + '<div class="note_desc"><div class="note_created">'+note.first_name+' '+note.last_name+': '+note.created+'</div>';
        h = h + '<div class="note_comment">';
        h = h + note.note;
        h = h + '</div></div></div>';
        return h;
    }
});
</script>