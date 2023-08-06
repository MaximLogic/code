<?php
namespace Perspective\CancelOrder\Model\ResourceModel\CanceledOrder;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'perspective_cancelorder_canceled_order_collection';
    protected $_eventObject = 'canceled_order_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Perspective\CancelOrder\Model\CanceledOrder', 'Perspective\CancelOrder\Model\ResourceModel\CanceledOrder');
    }
}
