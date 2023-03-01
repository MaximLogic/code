<?php
namespace ProductsViewModel\GetQty\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class CurrentProductQty implements ArgumentInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $_registry;

    /**
     * @var \Magento\CatalogInventory\Api\StockStateInterface
     */
    private $_stockState;

    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\CatalogInventory\Api\StockStateInterface $stockState
    )
    {
        $this->_registry = $registry;
        $this->_stockState = $stockState;
    }

    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

    public function getProductStockInfo()
    {
        $product = $this->getCurrentProduct();
        $productQty = $this->_stockState->getStockQty($product->getId(), 0);
        return [
            $product->getName(), 
            $productQty, 
            $productQty > 0 ? "Yes" : "No"
        ];
    }
}
