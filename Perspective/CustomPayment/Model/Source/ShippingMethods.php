<?php
namespace Perspective\CustomPayment\Model\Source;

use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Shipping\Model\Config;

class ShippingMethods extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var \Magento\Shipping\Model\Config\Source\Allmethods
     */
    private $allMethods;

    public function __construct(
        \Magento\Shipping\Model\Config\Source\Allmethods $allMethods
    )
    {
        $this->allMethods = $allMethods;
    }

    public function getAllOptions()
    {
        return $this->allMethods->toOptionArray(true);
    }
}
