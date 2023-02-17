<?php
namespace Perspective\HelloWorld\Block;
use \Magento\Framework\View\Element\Template\Context;
class Index extends \Magento\Framework\View\Element\Template
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
    public function sayHello()
    {
        return __('Learn Magento 2 Block Layout');
    }
}