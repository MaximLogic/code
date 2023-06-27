define(
    [
      'Magento_Checkout/js/view/payment/default'
    ],
    function (Component) {
      'use strict';
  
      return Component.extend({
        defaults: {
          template: 'Perspective_CustomPayment/payment/customtemplate'
        },
      
        /** Returns send check to info */
        getMailingAddress: function() {
          return window.checkoutConfig.payment.customtemplate.mailingAddress;
        }
      
      });
    }
  );