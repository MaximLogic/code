<?php
namespace Perspective\Sales\Model\ResourceModel\Sales;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'sale_id';
    protected $_eventPrefix = 'perspective_sales_sales_collection';
    protected $_eventObject = 'sales_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Perspective\Sales\Model\Sales', 'Perspective\Sales\Model\ResourceModel\Sales');
    }
}
