'use strict';

require('jquery-validation');

function initCheckout() {
    var $checkout = $('.groups-btn .checkout');
    var $checkoutMessage = $('p.checkout-message');
    var $formCheckout = $('#form-checkout');
    var $checkoutNow = $formCheckout.find('button[class="btn-primary"]');

    $formCheckout.validate();

    $checkout.click(function() {
        $checkoutMessage.html('');
        
        $.fancybox.open({
            src: '#form-checkout',
            touch : false,
            autoSize: false,
            width: '600px',
            hideScrollbar: true
        });

        return false;
    });

    $formCheckout.find('button#form_send').on('click', function(e) {
        if ($formCheckout.valid()) {

        }
    });
}

exports.init = function () {
    initCheckout();
};