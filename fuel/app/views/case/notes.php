<div id="notes_wrapper">
    <div id="notes">
        <h2>Notes</h2>
        <textarea name="notes" id="case_notes"><?php echo $notes;?></textarea>
        <button class="btn primary" id="save_notes">Quick Save Notes</button>
    </div>
</div>

<script type="text/javascript">
 
$(function() {
    var a = function() {
        var b = $(window).scrollTop();
        var d = $("#notes_wrapper").offset().top;
        var c = $("#notes");
        if (b > d) {
            c.css({position:"fixed",top:"0px", right: "0px"})
        } else {
            c.css({position:"absolute",top:""})
        }
    };
    $(window).scroll(a);a()
    
    $("#save_notes").click(function(e){
        $.post('/case/save_notes/<?php echo uri::segment(3);?>', {notes: $("#case_notes").val()})
        .success(function(){
            $("#case_notes").effect('highlight',{color: '#baeaba'}, 3000);
        });
        e.preventDefault();
    });
});


</script>