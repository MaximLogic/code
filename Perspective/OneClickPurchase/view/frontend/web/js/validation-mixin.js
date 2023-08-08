define(['jquery', 'Magento_Ui/js/lib/validation/utils'], function($, utils) {
    'use strict';
  
    return function(targetWidget) {
        $.validator.addMethod(
            'phoneUA',
            function(value, element) {
                return utils.isEmpty(value) || value.length > 9 &&
                    value.match(/^((\+?3)?8)?0 (39|50|63|66|67|68|91|92|93|94|95|96|97|98|99|31|32|33|34|35|36|37|38|41|42|43|44|46|47|48|49|51|52|53|54|55|56|57|58|59|61|62|64|65|69) \d{3}-\d{2}-\d{2}$/);
            },
            $.mage.__('Введіть правильний номер типу +380 00 000-00-00')
        );
        $.validator.addMethod(
            'custom-email-validate',
            function(value, element) {
                return value.match(/[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/);
            },
            $.mage.__('Введіть правильну пошту')
        );
        return targetWidget;
    }
});