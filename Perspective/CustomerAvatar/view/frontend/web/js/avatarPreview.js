define([
    'jquery'
], function($) {
    'use strict';
    return function(config, element){
        element.addEventListener('change', function(){
            if(element.files && element.files[0]){
                const reader = new FileReader();
                reader.onload = function(e){
                    $('#preview-image')
                    .attr('src', e.target.result)
                    .width(250);
                };
                reader.readAsDataURL(element.files[0]);
            }
        })
    }
});