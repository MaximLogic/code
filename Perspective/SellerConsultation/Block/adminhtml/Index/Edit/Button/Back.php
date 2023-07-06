<?php
namespace Perspective\SellerConsultation\Block\adminhtml\Index\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Perspective\SellerConsultation\Block\adminhtml\Index\Edit\Button\Generic;

class Back extends Generic implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back'
        ];
    }

    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}
