<?php
namespace Perspective\DbWareHouse\Model;

class Post extends \Magento\Framework\Model\AbstractModel
{

    protected function _construct()
    {
        $this->_init('Perspective\DbWareHouse\Model\ResourceModel\Post');
    }

}
