$(function () {
    var $form = $(".stripe-payment");
    $('form.stripe-payment').bind('submit', function (e) {
        var $form = $(".stripe-payment"),
            inputVal = ['input[type=email]', 'input[type=password]',
                'input[type=text]', 'input[type=file]',
                'textarea'
            ].join(', '),
            $inputs = $form.find('.required').find(inputVal),
            $errorStatus = $form.find('div.error'),
            valid = true;
        $errorStatus.addClass('hide');

        $('.has-error').removeClass('has-error');
        $inputs.each(function (i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('text-danger');
                $input.addClass('is-invalid');
                $errorStatus.removeClass('hide');
                e.preventDefault();
            }
        });
        
        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            if($('.card_number').val().length != 16){
                $('.card_number').addClass('is-invalid');
                $('.card_number').parent().addClass('text-danger');
            }
            if($('.card-cvc').val().length != 3){
                $('.card-cvc').addClass('is-invalid');
                $('.card-cvc').parent().addClass('text-danger');
            }
            if($('.card-expiry-month').val().length != 2){
                $('.card-expiry-month').addClass('is-invalid');
                $('.card-expiry-month').parent().addClass('text-danger');
            }
            if($('.card-expiry-year').val().length != 4){
                $('.card-expiry-year').addClass('is-invalid');
                $('.card-expiry-year').parent().addClass('text-danger');
            }
            Stripe.createToken({
                number: $('.card_number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeRes);
        }

    });

    function stripeRes(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
});
