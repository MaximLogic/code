<?php
namespace Perspective\GuessCityIp\Model\ResourceModel;

class City extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('np_cities', 'entity_id');
    }
}
