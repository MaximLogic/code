<?php

namespace Perspective\CustomPayment\Model;

class CustomPayment extends \Magento\Payment\Model\Method\AbstractMethod
{

    const PAYMENT_METHOD_CUSTOM_INVOICE_CODE = 'custompayment';

    /**
    * Payment method code
    *
    * @var string
    */
    protected $_code = self::PAYMENT_METHOD_CUSTOM_INVOICE_CODE;
}