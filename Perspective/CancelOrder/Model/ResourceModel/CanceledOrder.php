<?php
namespace Perspective\CancelOrder\Model\ResourceModel;

class CanceledOrder extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('cancelled_orders', 'entity_id');
    }
}
