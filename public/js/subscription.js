$("#check_promo_code").click(function(){
    if($('#promo_code').val()){
        var url = $(this).data('url');
        $.ajax({
            method: "GET",
            url: url,
            data: { code: $('#promo_code').val()}
        })
        .done(function( msg ) {
            if(msg.fail){
                $('#promo_code').parent().addClass('text-danger');
                $('#promo_code').addClass('is-invalid');
            }else{
                $('#promo_code').parent().removeClass('text-danger');
                $('#promo_code').removeClass('is-invalid');
                //
                $('#promo_code').parent().addClass('text-success');
                $('#promo_code').addClass('is-valid');

                $("#promo_code").prop("readonly", true);
                $("#promo_code_label").text("Cut off " + msg.success.percentage + "% from price")
            }
        });
    }
});

$('#pay').click(function(){
    $('#payment').fadeIn(1000);
    $('html, body').animate({
        scrollTop: $("#payment").offset().top
    }, 2000);
})

