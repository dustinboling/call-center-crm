
$(document).ready(function(){
   $(".datepicker").datepicker();
    $("input").attr('autocomplete', 'off');
    $(".tablecollapse").css('cursor', 'pointer');
    $(".tablecollapse").click(function() {
        $(this).siblings().toggle();
    });
    
    
    $("#export_calls").click(function(e){

        new_uri = window.location.href+'&export=true';

        window.location.href = new_uri;
        e.preventDefault();

    });
    
});

function conf(msg) {
    if (confirm(msg)){
        return true;
    }
    return false;
}
