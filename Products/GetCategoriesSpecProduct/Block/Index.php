<?php
namespace Products\GetCategoriesSpecProduct\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $_categoryCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $_productRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = []
    ) 
    {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    public function getProductById($id)
    {        
        if(is_null($id))
        {
            return null;
        }
        return $this->_productRepository->getById($id);
    }

    public function getCategoryCollection($isActive = true, $level = false, $sortBy = false, $pageSize = false)
    {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');        
        
        if ($isActive) {
            $collection->addIsActiveFilter();
        }
                
        if ($level) {
            $collection->addLevelFilter($level);
        }
        
        if ($sortBy) {
            $collection->addOrderField($sortBy);
        }
        
        if ($pageSize) {
            $collection->setPageSize($pageSize); 
        }    
        
        return $collection;
    }
}
