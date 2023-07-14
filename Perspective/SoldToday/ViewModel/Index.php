<?php
namespace Perspective\SoldToday\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Index implements ArgumentInterface
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $productRepository;

    /**
     * @var \Magento\ConfigurableProduct\Model\Product\Type\Configurable
     */
    private $configurable;

    /**
     * @var \Magento\GroupedProduct\Model\Product\Type\Grouped
     */
    private $grouped;

    public function __construct(
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $collectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable,
        \Magento\GroupedProduct\Model\Product\Type\Grouped $grouped
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->productRepository = $productRepository;
        $this->configurable = $configurable;
        $this->grouped = $grouped;
        
    }

    public function getOrderCollection()
    {
        $currentDay = (new \DateTime())->format("Y-m-d") . ' 00:00:00';
        $collection = $this->collectionFactory
                           ->create()
                           ->addAttributeToSelect('*')
                           ->addFieldToFilter('created_at', ['gt' => $currentDay]);
        return $collection;
    }

    public function getUrlByProdId($id)
    {
        $parentProductIds = $this->configurable->getParentIdsByChild($id);
        if(isset($parentProductIds[0]))
        {
            foreach($parentProductIds as $parentId)
            {
                return $this->productRepository->getById($parentId)->getUrlKey();
            }
        }
        return $this->productRepository->getById($id)->getUrlKey();
    }

    public function getProductById($productId)
    {
        return $this->productRepository->getById($productId);
    }

    public function isCommonCategories($product1, $product2)
    {
        return count(array_intersect($product1->getCategoryIds(), $product2->getCategoryIds())) != 0;
    }
}
