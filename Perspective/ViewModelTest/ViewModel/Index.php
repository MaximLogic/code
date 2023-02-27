<?php
namespace Perspective\ViewModelTest\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Index implements ArgumentInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $_productCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $_productRepository;

    /**
     * @var \Magento\CatalogInventory\Api\StockStateInterface
     */
    private $_stockState;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\CatalogInventory\Api\StockStateInterface $stockState
    )
    {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_productRepository = $productRepository;
        $this->_stockState = $stockState;
    }

    public function getProductStockInfo($productId)
    {
        if(is_null($productId))
        {
            return null;
        }
        $product = $this->_productRepository->getById($productId);
        $productQty = $this->_stockState->getStockQty($productId, 0);
        return [
            $product->getName(), 
            $productQty, 
            $productQty > 0 ? "Yes" : "No"
        ];
    }
}
