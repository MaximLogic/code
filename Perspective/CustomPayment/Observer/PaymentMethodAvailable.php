<?php

namespace Perspective\CustomPayment\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class PaymentMethodAvailable implements ObserverInterface
{

    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var \Magento\Customer\Api\GroupRepositoryInterface
     */
    private $groupRepository;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        $this->groupRepository = $groupRepository;
        
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customerGroupId = $this->customerSession->getCustomer()->getGroupId();
        $customerGroupCode = $this->groupRepository->getById($customerGroupId)->getCode();

        $orderTotal = $this->checkoutSession->getQuote()->getSubtotal();
        $itemsTotal = $this->checkoutSession->getQuote()->getItemsQty();
        $moreThanTotalConf = $this->scopeConfig->getValue('payment/custompayment/big_opt_more_than');
        $moreThanQtyConf = $this->scopeConfig->getValue('payment/custompayment/opt_more_than');
        $bigOptPaymentMethodConf = $this->scopeConfig->getValue('payment/custompayment/big_opt_payment_method');
        $optPaymentMethodConf = $this->scopeConfig->getValue('payment/custompayment/opt_payment_method');

        if($this->customerSession->isLoggedIn()
            && $customerGroupCode == "Big Opt"
            && $observer->getEvent()->getMethodInstance()->getCode() != $bigOptPaymentMethodConf)
        {
            if($orderTotal > $moreThanTotalConf)
            {
                $checkResult = $observer->getEvent()->getResult();
                $checkResult->setData('is_available', false); 
                return;
            }
        }
        
        if($this->customerSession->isLoggedIn()
            && $customerGroupCode == "Opt"
            && $itemsTotal > $moreThanQtyConf
            && $observer->getEvent()->getMethodInstance()->getCode() != $optPaymentMethodConf)
        {
            $checkResult = $observer->getEvent()->getResult();
            $checkResult->setData('is_available', false); 
            return;
        }

        if($observer->getEvent()->getMethodInstance()->getCode()=="custompayment")
        {
            $shippingMethod = $this->checkoutSession->getQuote()->getShippingAddress()->getShippingMethod();
            $shippingMethodArr = explode('_', $shippingMethod);
            $carrierCode = $shippingMethodArr[0];
            if($carrierCode != "customshipping")
            {
                $checkResult = $observer->getEvent()->getResult();
                $checkResult->setData('is_available', false); 
                return;
            }

            $categoryIds = array_map('intval', explode(',', $this->scopeConfig->getValue('payment/custompayment/categories')));
            $cartProducts = $this->checkoutSession->getQuote()->getAllItems();
            foreach($cartProducts as $item)
            {
                $product = $item->getProduct();
                $productCategoryIds = $product->getCategoryIds();
                if(count(array_intersect($categoryIds, $productCategoryIds)) == 0)
                {
                    $checkResult = $observer->getEvent()->getResult();
                    $checkResult->setData('is_available', false); 
                    return;
                }
            }
        }
        
    }
}