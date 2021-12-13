$("#show_name").change(function(){
    $.ajax({
        method: "PATCH",
        url: $(this).data('url'),
        data: { show_name: $(this).val() }
    })
    .done(function( msg ) {
        location.reload();
    });
})
    