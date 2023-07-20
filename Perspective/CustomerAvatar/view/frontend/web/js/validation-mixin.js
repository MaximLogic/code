define([
    'jquery'
], function ($) {
    return function(targetWidget) {
        $.validator.addMethod(
            'validate-image-type', 
            function (value, element) {
                if(element.files && element.files[0]){
                    if(element.files[0].type != 'image/jpeg'){
                        return false;
                    }
                }
                return true;
            }, $.mage.__('Image invalid (Accepting format .jpg .jpeg)')
        );
        return targetWidget;
    }
});