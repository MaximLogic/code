define([
    'jquery',
    'Perspective_ProductWishList/js/wishlistsWidget'
], function($) {
    return function(config, element){
        $(element).wishlistsWidget({
            count: config.count
        });
    }
});