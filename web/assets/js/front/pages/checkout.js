'use strict';

require('jquery-validation');

function initCheckout() {
    var $checkout = $('.groups-btn .checkout');
    var $checkoutMessage = $('p.checkout-message');
    var $formCheckout = $('#form-checkout');

    $formCheckout.validate();

    $checkout.click(function() {
        $checkoutMessage.html('');
        
        $.fancybox.open({
            src: '#checkout',
            touch : false,
            autoSize: false,
            width: '600px',
            hideScrollbar: true
        });

        return false;
    });

    $formCheckout.find('button#form_send').on('click', function(e) {
        var productId = $formCheckout.data('productId');
        var quantity = $formCheckout.find('input[name="quantity"]').val();

        if ($formCheckout.valid()) {
            $.ajax({
                type: "POST",
                url: $formCheckout.attr('action'),
                data: $formCheckout.serialize() + '&productId=' + productId + '&quantity=' + quantity,
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response.status === 'success') {
                        $('p#checkout-message').html(response.message).show();
    
                        $formCheckout[0].reset();
                        $formCheckout.hide();
                    } else {
                        $('p#checkout-message').html(response.message).show();
                    }
                }
            });
        }
    });
}

exports.init = function () {
    initCheckout();
};