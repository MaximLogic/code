<?php
namespace Perspective\PriceGroups\ViewModel;

class Data implements \Magento\Framework\View\Element\Block\ArgumentInterface
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $productRepository;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\ProductRepository $productRepository
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
    }

    public function isModuleEnabled()
    {
        return $this->scopeConfig->getValue('pricegroupsconf/general/enable');
    }

    public function isBasePriceEnabled()
    {
        return $this->scopeConfig->getValue('pricegroupsconf/general/baseprice');
    }

    public function isFinalPriceEnabled()
    {
        return $this->scopeConfig->getValue('pricegroupsconf/general/finalprice');    
    }

    public function isSpecialPriceEnabled()
    {
        return $this->scopeConfig->getValue('pricegroupsconf/general/specialprice');
    }

    public function isTierPriceEnabled()
    {
        return $this->scopeConfig->getValue('pricegroupsconf/general/tierprice');
    }

    public function isCatalogRulePriceEnabled()
    {
        return $this->scopeConfig->getValue('pricegroupsconf/general/catalogruleprice');
    }
}
