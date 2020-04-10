'use strict';

var $ = require('jquery');

require('bootstrap-sass');

var news = require('./pages/news');
var product = require('./pages/product');
var checkout = require('./pages/checkout');
var global = require('./global/global');

var app = {
    init: function () {
        news.init();
        global.init();
        product.init();
        checkout.init();
    }
};

// initialize app
$(document).ready(function () {
    app.init();
});