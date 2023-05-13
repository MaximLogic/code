<?php
namespace Perspective\PriceDiscountCron\Model\Source;

class CustomerGroups extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * @var \Magento\Customer\Model\ResourceModel\Group\Collection
     */
    private $groupCollection;

    public function __construct(
        \Magento\Customer\Model\ResourceModel\Group\Collection $groupCollection
    )
    {
        $this->groupCollection = $groupCollection;
        
    }

    public function getAllOptions()
    {
        if (!$this->_options) 
        {
            $collection = $this->groupCollection->toOptionArray();
            $this->_options = $collection;
        }
        
        return $this->_options;
    }
}
