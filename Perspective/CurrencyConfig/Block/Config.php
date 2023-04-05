<?php
namespace Perspective\CurrencyConfig\Block;

class Config extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Perspective\CurrencyConfig\Helper\Data
     */
    private $helperData;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Perspective\CurrencyConfig\Helper\Data $helperData,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->helperData = $helperData;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }
    
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function isEnabled()
    {
        return $this->helperData->isEnabled();
    }

    public function getUahCourse()
    {
        return $this->helperData->getUahCourse();
    }

    public function getRubCourse()
    {
        return $this->helperData->getRubCourse();
    }

    public function getEuroCourse()
    {
        return $this->helperData->getEuroCourse();
    }
}