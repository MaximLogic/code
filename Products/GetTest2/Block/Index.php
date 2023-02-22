<?php
namespace Products\GetTest2\Block;

class Index extends \Magento\Framework\View\Element\Template
{
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
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        array $data = []
    ) 
    {
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getProductsFiltered()
    {
        $productCollection = $this->_productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        //$productCollection->addAttributeToFilter('type_id', ['eq' => 'virtual']);
        $productCollection->addCategoriesFilter(['eq' => 23]);
        $productCollection->addAttributeToFilter('price', ['gt' => 50]);
        $productCollection->addAttributeToFilter('price', ['lt' => 60]);
        $productCollection->setPageSize(1000);

        return $productCollection;
    }
}
