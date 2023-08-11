define([
    'jquery',
    'Magento_Checkout/js/action/get-totals',
    'Magento_Customer/js/customer-data',
    'Magento_Checkout/js/model/cart/cache',
    'Magento_Checkout/js/model/cart/totals-processor/default',
    'Magento_Checkout/js/model/quote'
], function ($, getTotalsAction, customerData, cartCache, totalsProcessor, quote) {
    $(document).ready(function(){
        deleteButtonAjaxBind();
        changeSelectedSize();
        changeSelectedColor();
        $(document).on('change', 'input[name$="[qty]"]', function(){
            var form = $('form#form-validate');
            $.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                showLoader: true,
                success: function (response) {
                    formReload(response);
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        });

        $('#coupon_code').on('change', function(){
            var form = $('form#discount-coupon-form');
            $.ajax(
                {
                    type: "POST",
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function (response) {
                        cartCache.clear('cartVersion');
                        totalsProcessor.estimateTotals(quote.shippingAddress());
                    },
                    error: (xhr, status, error) => {
                        console.log(error);
                    }
                }
            );
        });

        function deleteButtonAjaxBind(){
            $('.action.action-delete').each((index, element) => {
                var dataPost = $(element).data('post');
                $(element).on('click', () => {
                    $(element).removeAttr('data-post');
                    var dataId = dataPost.data;
                    var formKey = $("input[name='form_key']").val();
                    $.ajax({
                        type: "POST",
                        url: '/checkout/cart/delete/',
                        data: {
                            'id': dataId.id,
                            'form_key': formKey
                        },
                        showLoader: true,
                        success: function (response) {
                            formReload(response);
                        },
                        error: (xhr, status, error) => {
                            console.log(error);
                        }
                    });
                });
            });
        }

        function changeSelectedSize()
        {
            $('tbody').each(function () {
                var id = $(this).closest('tbody').find('input').val();
                var qty = $(this).find("td.col.qty").find('input').val();
                $('#' + id + 'size' + ' div').on('click', function () {
                    $('#' + id + 'size' + ' div.selected').removeClass('selected');
                    $(this).addClass('selected');
                    var selectedSize = $(this).text();
                    $.ajax({
                        url: "http://magento245.loc/cartReload/index/index",
                        type: "POST",
                        data: {'sku': id, 'selectedColor': "", 'selectedSize': selectedSize, 'qty': qty},
                        showLoader: true,
                        cache: false,
                        success: function (res) {
                            var form = $('form#form-validate');
                            $.ajax({
                                url: form.attr('action'),
                                data: form.serialize(),
                                showLoader: true,
                                success: function (response) {
                                    formReload(response);
                                },
                                error: function (xhr, status, error) {
                                    console.log(error);
                                }
                            });
                        }
                    });
                });
            })
        }
        function changeSelectedColor()
        {
            $('tbody').each(function () {
                var id = $(this).closest('tbody').find('input').val();
                var qty = $(this).find("td.col.qty").find('input').val();
                $('#' + id + ' div').on('click', function () {
                    var selectedId = $('#' + id + ' div').index(this);
                    $('#' + id + ' div.selected').removeClass('selected');
                    $(this).addClass('selected');
                    var selectedColor = $(this).data('color');
                    $.ajax({
                        url: "http://magento245.loc/cartReload/index/index",
                        type: "POST",
                        data: {'sku': id, 'selectedColor': selectedColor, 'selectedSize': "", 'qty': qty},
                        showLoader: true,
                        cache: false,
                        success: function (res) {
                            var form = $('form#form-validate');
                            $.ajax({
                                url: form.attr('action'),
                                data: form.serialize(),
                                showLoader: true,
                                success: function (response) {
                                    formReload(response);
                                },
                                error: function (xhr, status, error) {
                                    var err = eval("(" + xhr.responseText + ")");
                                    console.log(err.Message);
                                }
                            });
                        }
                    });
                });
            })
        }

        function formReload(response)
        {
            var parsedResponse = $.parseHTML(response);
            var result = $(parsedResponse).find("#form-validate");
            var sections = ['cart'];

            $("#form-validate").replaceWith(result);
            /* Minicart reloading */
            customerData.reload(sections, true);

            /* Totals summary reloading */
            var deferred = $.Deferred();
            getTotalsAction([], deferred);
            deleteButtonAjaxBind();
            changeSelectedColor();
            changeSelectedSize();
        }
    });
});