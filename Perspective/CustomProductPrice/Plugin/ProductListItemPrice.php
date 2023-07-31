<?php
namespace Perspective\CustomProductPrice\Plugin;

class ProductListItemPrice
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $productRepository;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->productRepository = $productRepository;
        $this->scopeConfig = $scopeConfig;
        
    }

    public function aroundGetProductPrice(
        \Magento\Catalog\Block\Product\ListProduct $subject,
        \Closure $proceed,
        \Magento\Catalog\Model\Product $product)
    {
        $moduleEnable = $this->scopeConfig->isSetFlag('customprice/general/enable');
        if($moduleEnable)
        {
            $productCurr = $this->productRepository->getById($product->getId());
            $customPrice = $productCurr->getPCustomPrice();
            if($customPrice)
            {
                $customPrice = number_format((float)$customPrice, 2, '.', '');
                return "<b>$$customPrice</b>";
            }
        }
        $price = number_format((float)$product->getFinalPrice(), 2, '.', '');
        return "<b>$$price</b>";
    }
}
