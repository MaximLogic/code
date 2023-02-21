<?php
namespace Products\GetProductsFilterVisibility\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $_productCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    private $_productStatus;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    private $_productVisibility;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus,
        \Magento\Catalog\Model\Product\Visibility $productVisibility,
        array $data = []
    ) 
    {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_productStatus = $productStatus;
        $this->_productVisibility = $productVisibility;
        parent::__construct($context, $data);
    }

    public function getProductCollectionFilterVisibility()
    {
        $productCollection = $this->_productCollectionFactory->create();
        $productCollection->addAttributeToFilter('status', ['in' => $this->_productStatus->getVisibleStatusIds()]);
        $productCollection->setVisibility($this->_productVisibility->getVisibleInSiteIds());
        $productCollection->setPageSize(5);
        return $productCollection;
    }
}
