$(document).ready(function(){
        
    $('a.recording').colorbox({href: $(this).attr('href'), width: 400, height: 300});
    $('a.view_notes').colorbox({href: $(this).attr('href'), width: 700, height: 500});

    $(".new_disposition").live('click', function(e){
        val = $(this).html();

        $(this).parents('.disposition').find('.set_disposition').html(val);
            $(this).parents('.disposition_list').hide().html('');

        $.get($(this).attr('href'));

        e.preventDefault();
    });

    $(".disposition").live('mouseout', function(){ 
       $(document.body).data('disposition_active', false);
       setTimeout(function(){handle_disposition_status()},100);
    }).live('mouseover', function(){
        $(document.body).data('disposition_active', true);
    });

    $(".disposition_list").live('mouseout', function(){ 
       $(document.body).data('disposition_list_active', false);
       setTimeout(function(){handle_disposition_status()},100);
    }).live('mouseover', function(){
        $(document.body).data('disposition_list_active', true);
    });

});

function handle_disposition_status(item){
    if(!$(document.body).data('disposition_active') && !$(document.body).data('disposition_list_active')){
        $(document.body).data('disposition_list').hide();
    }
}