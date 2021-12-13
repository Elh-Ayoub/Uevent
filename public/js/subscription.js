var id = $("#pay").data('id');
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
                $("#stripe-payment").append('<input type="text" name="promocode" value="' + msg.success.code +'" class="d-none" readonly>')

                if(msg.success.percentage == 100){
                    $("#price").parent().html("Free")
                    //
                    $("#pay").parent().html('<button class="btn btn-info btn-lg btn-fla" onclick="subscribe()"><i class="fas fa-plus-circle mr-2"></i>Free subscription</button>')
                }else{
                    price = parseInt($("#price").html())
                    price -= (price * msg.success.percentage)/100
                    $("#price").html(price)
                }
                
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

function subscribe(){
    var getUrl = window.location;
    var url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/" + id +"/free-subscribe";
    
    $.ajax({
        method: "POST",
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    })
    .done(function( msg ) {
        if(msg.fail){
            toastr.error(msg.fail)
        }else{
            toastr.success(msg.success)
        }
    })
}

