<?php
namespace Perspective\CurrencyConfig\Block;

class Config extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Perspective\CurrencyConfig\Helper\Data
     */
    private $helperData;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Directory\Model\CurrencyFactory
     */
    private $currencyFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Perspective\CurrencyConfig\Helper\Data $helperData,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\CurrencyFactory $currencyFactory,
        array $data = []
    ) {
        $this->helperData = $helperData;
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->currencyFactory = $currencyFactory;
        parent::__construct($context, $data);
    }
    
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function isEnabled()
    {
        return $this->helperData->isEnabled();
    }

    public function getUahCourse()
    {
        return $this->helperData->getUahCourse();
    }

    public function getRubCourse()
    {
        return $this->helperData->getRubCourse();
    }

    public function getEuroCourse()
    {
        return $this->helperData->getEuroCourse();
    }
    
    public function getAvailableCurrencyCodes($skipBaseNotAllowed = false)
    {
        return $this->_storeManager->getStore()->getAvailableCurrencyCodes($skipBaseNotAllowed);
    }
    
    public function convertPriceFromCurrentToAnotherCurrency($price, $currencyCodeTo)
    {
        $curentCurrencyCode =  $this->storeManager->getStore()->getCurrentCurrency()->getCode();
        $rate = $this->currencyFactory->create()
                        ->load($curentCurrencyCode)
                        ->getAnyRate($currencyCodeTo);

        $convertedPrice = $price * $rate;

        return $convertedPrice;
    }
}