define([
    'jquery',
    'Perspective_SoldToday/js/widget'
], function($) {
    return function (config, element){
        $(element).customWidget({
            orders: config.orders
        });
    }
});