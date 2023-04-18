<?php
namespace Perspective\FreightAttribute\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Freight implements ArgumentInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Perspective\FreightAttribute\Helper\Data
     */
    private $helperData;

    public function __construct(
        \Magento\Framework\Registry $registry,
        \Perspective\FreightAttribute\Helper\Data $helperData
    )
    {
        $this->registry = $registry;
        $this->helperData = $helperData;
        
    }
    
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function isAirFreightEnabled()
    {
        return $this->helperData->isEnabled();
    }

    public function getBaloonMax()
    {
        return $this->helperData->getBaloonMax();
    }
    public function getBaloonMargin()
    {
        return $this->helperData->getBaloonMargin();
    }

    public function getCharterPlaneMax()
    {
        return $this->helperData->getCharterPlaneMax();
    }
    public function getCharterPlaneMargin()
    {
        return $this->helperData->getCharterPlaneMargin();
    }

    public function getHighspeedPlaneMax()
    {
        return $this->helperData->getHighspeedPlaneMax();
    }
    public function getHighspeedPlaneMargin()
    {
        return $this->helperData->getHighspeedPlaneMargin();
    }

    public function getSpaceshipMax()
    {
        return $this->helperData->getSpaceshipMax();
    }
    public function getSpaceshipMargin()
    {
        return $this->helperData->getSpaceshipMargin();
    }
}
