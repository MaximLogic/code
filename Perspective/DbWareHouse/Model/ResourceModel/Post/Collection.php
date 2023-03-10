<?php
namespace Perspective\DbWareHouse\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public function __construct()
    {
        $this->_init('Perspective\DbWareHouse\Model\Post', 'Perspective\DbWareHouse\Model\ResourceModel\Post');
    }
}
