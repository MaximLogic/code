<?php
namespace Perspective\QuantityConfig\Block;

class Config extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Perspective\QuantityConfig\Helper\Data
     */
    private $helperData;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Magento\CatalogInventory\Api\StockStateInterface
     */
    private $stockState;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Perspective\QuantityConfig\Helper\Data $helperData,
        \Magento\Framework\Registry $registry,
        \Magento\CatalogInventory\Api\StockStateInterface $stockState,
        array $data = []
    ) {
        $this->helperData = $helperData;
        $this->registry = $registry;
        $this->stockState = $stockState;
        parent::__construct($context, $data);
    }

    public function isEnabled()
    {
        return $this->helperData->isEnabled();
    }

    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function getStockQty($productId, $websiteId = null)
    {
        return $this->stockState->getStockQty($productId, $websiteId);
    }

    public function getX()
    {
        return $this->helperData->getX();
    }
}
