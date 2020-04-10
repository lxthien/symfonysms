exports.init = function () {
    $('.product-shop .spr-badge .rating').on('click', function(e) {
        $('.tabs__product-page .nav-tabs li').eq(1).click();
        $('html, body').animate({
            scrollTop: $(".product_bottom").offset().top - 100
        }, 1000);
    });
};