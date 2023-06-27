<?php
namespace Perspective\CustomPayment\Plugin;

class ApplyShipping
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var \Magento\Customer\Api\GroupRepositoryInterface
     */
    private $groupRepository;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->groupRepository = $groupRepository;
        
    }

    public function aroundCollectCarrierRates(
        \Magento\Shipping\Model\Shipping $subject,
        \Closure $proceed,
        $carrierCode,
        $request
    )
    {
        $customerGroupId = $this->customerSession->getCustomer()->getGroupId();
        $customerGroupCode = $this->groupRepository->getById($customerGroupId)->getCode();

        $orderTotal = $this->checkoutSession->getQuote()->getSubtotal();
        $itemsTotal = $this->checkoutSession->getQuote()->getItemsQty();
        $moreThanTotalConf = $this->scopeConfig->getValue('payment/custompayment/big_opt_more_than');
        $moreThanQtyConf = $this->scopeConfig->getValue('payment/custompayment/opt_more_than');
        $optShippingMethodConf =  $this->scopeConfig->getValue('payment/custompayment/opt_shipping_method');

        if ($carrierCode == 'freeshipping') {
            if ($this->customerSession->isLoggedIn() && $customerGroupCode != "Big Opt") 
            {
                return false;
            }
            
            else if(!$this->customerSession->isLoggedIn())
            {
                return false;
            }
        }

        if($this->customerSession->isLoggedIn() 
            && $customerGroupCode == "Big Opt" 
            && $orderTotal > $moreThanTotalConf 
            && $carrierCode != 'freeshipping')
        {
            return false;
        }

        if($this->customerSession->isLoggedIn() 
            && $customerGroupCode == "Opt" 
            && $itemsTotal > $moreThanQtyConf
            && $carrierCode != explode('_', $optShippingMethodConf)[0])
        {
            return false;
        }

        return $proceed($carrierCode, $request);
    }
}
