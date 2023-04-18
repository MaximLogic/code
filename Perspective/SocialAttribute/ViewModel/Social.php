<?php
namespace Perspective\SocialAttribute\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Social implements ArgumentInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Perspective\SocialAttribute\Helper\Data
     */
    private $helperData;


    public function __construct(
        \Magento\Framework\Registry $registry,
        \Perspective\SocialAttribute\Helper\Data $helperData
    )
    {
        $this->registry = $registry;
        $this->helperData = $helperData;
    }

    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }
    
    public function isSocialEnabled()
    {
        return $this->helperData->isEnabled();
    }

    public function getDiscount()
    {
        return $this->helperData->getDiscount();
    }

    public function isProductSocial($product)
    {
        $social = $product->getSocial();
        if($social)
        {
            return true;
        }
        
        return false;
    }
}
