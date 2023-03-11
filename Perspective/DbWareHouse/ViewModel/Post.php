<?php
namespace Perspective\DbWareHouse\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Post implements ArgumentInterface
{
    /**
     * @var \Perspective\DbWareHouse\Model\PostFactory
     */
    private $_postFactory;

    public function __construct(
        \Perspective\DbWareHouse\Model\PostFactory $_postFactory
    )
    {
        $this->_postFactory = $_postFactory;
        
    }

    public function getPostCollection()
    {
        $post = $this->_postFactory->create();
        $collection = $post->getCollection();

        return $collection;
    }
}
