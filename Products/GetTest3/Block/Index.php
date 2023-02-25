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
     * @var \Magento\Catalog\Model\ProductFactory
     */
    private $_productFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product
     */
    private $_productResource;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product $productResource,
        array $data = []
    ) 
    {
        $this->_productRepository = $productRepository;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_productFactory = $productFactory;
        $this->_productResource = $productResource;
        parent::__construct($context, $data);
    }

    public function getProductById($productId)
    {
        if(is_null($productId))
        {
            return null;
        }
        
        $product = $this->_productFactory->create();
        $this->_productResource->load($product, $productId);
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

    public function getChildrenProductsIds($product)
    {
        $productId = $product->getId();
        $productModel = $this->getProductById($productId);
        $childrenProductsIds = $productModel->getTypeInstance()->getChildrenIds($productId);
        return $childrenProductsIds;
    }

    public function getChildrenConfProduct($product)
    {
        $productId = $product->getId();
        $parentprod = $this->getProductById($productId);
        // $children = $parentprod->getTypeInstance()->getUsedProducts($parentprod);
        $children = $parentprod->getTypeInstance()->getChildrenIds
        ($productId);
        if($children) 
        {
            return $children;
        }
        return false;
    }
}
