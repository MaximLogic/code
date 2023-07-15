define([
    'jquery',
    'jquery-ui-modules/widget'
], function($) {
    $.widget('perspective.wishlistsWidget', {
        _create(){
            const wishlistsCount = document.createElement('h1');
            const wishlistsCountText = document.createTextNode('In wishlists: ' + this.options.count);
            wishlistsCount.appendChild(wishlistsCountText);
            $(this.element).append(wishlistsCount);
        }
    })
});