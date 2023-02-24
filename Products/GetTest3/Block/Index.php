<?php
namespace Products\GetTest3\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $_productRepository;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $_productCollectionFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        array $data = []
    ) 
    {
        $this->_productRepository = $productRepository;
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getProductById($productId)
    {
        if(is_null($productId))
        {
            return null;
        }
        $product = $this->_productRepository->getById($productId);
        return $product;
    }

    public function getBundleProducts()
    {
        $productCollection = $this->_productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addAttributeToFilter("type_id", ['eq' => 'bundle']);
        $productCollection->setPageSize(5);
        return $productCollection;
    }

    public function getGroupedProducts()
    {
        $productCollection = $this->_productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addAttributeToFilter("type_id", ['eq' => 'grouped']);
        $productCollection->setPageSize(5);
        return $productCollection;
    }

    public function getChildrenProductsIds($productCollection)
    {
        $childrenProductsIds = $productCollection->getChildrenIds();
        return $childrenProductsIds;
    }
}
