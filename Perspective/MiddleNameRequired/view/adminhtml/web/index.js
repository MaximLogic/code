define([
    'jquery',
    'Magento_Sales/order/create/scripts'
], function ($){
    AdminOrder.prototype.setShippingMethod = function(shipping){
        if (shipping === 'freeshipping_freeshipping') {
            $(".field-middlename").addClass("required _required");
            $("#order-billing_address_middlename").addClass("required-entry _required");
        }
        else{
            $(".field-middlename").removeClass("required _required");
            $("#order-billing_address_middlename").removeClass("required-entry _required");
        }
    }
})  