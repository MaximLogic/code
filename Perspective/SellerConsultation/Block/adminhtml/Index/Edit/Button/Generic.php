<?php
namespace Perspective\SellerConsultation\Block\adminhtml\Index\Edit\Button;

class Generic
{
    protected $context;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        $this->context = $context;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
