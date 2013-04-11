
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

    $.get('/event/popups', function(data){
        triggerPopup(data);
    },'json')
    
    triggerPopups = setInterval(function(){
        $.get('/event/popups', function(data){
            triggerPopup(data);
        },'json')
    }, 60000)
    
});

function triggerPopup(data){

    if(data.length > 0){
        $.each(data, function(i,e){
            $("#alert_popup .modal-body").append('<p>'+e.at+' <a href="/case/view/'+e.case_id+'"> '+e.case_id+'</a> '+e.first_name+' '+e.last_name+'<br>'+e.title+'</p>');
            $.get("/event/record_popup/"+e.alert_id);
        })
        $("#alert_popup").modal();
        
    }
}

function conf(msg) {
    if (confirm(msg)){
        return true;
    }
    return false;
}
