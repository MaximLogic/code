<?php
namespace Perspective\CustomCartProductShipping\Model\Source;

class Categories extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollectionFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
    )
    {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    public function getAllOptions()
    {
        if (!$this->_options) 
        {
            $collection = $this->categoryCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->setStore(1)
            ->addAttributeToFilter('is_active','1');
            $this->_options = $collection->toOptionArray();
        }
        
        return $this->_options;
    }
}