define([
    'jquery',
    'jquery-ui-modules/widget'
], function($) {
    $.widget('perspective.customWidget', {
        _create(){
            this.options.orders.forEach(item => {
                const prodLink = document.createElement("a");

                const prodText = document.createTextNode(item.name);

                const link = document.createAttribute("href");
                link.value = item.url;

                prodLink.appendChild(prodText);
                prodLink.setAttributeNode(link);

                $(this.element).append(prodLink);
                $(this.element).append('<br>');
            });
        }
    });
    
    return $.perspective.customWidget;
});