<?php
namespace Perspective\SellerConsultation\Block\adminhtml\Index\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Perspective\SellerConsultation\Block\adminhtml\Index\Edit\Button\Generic;

class Save extends Generic implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Respond'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'perspective_sellerconsultation_respond_form.perspective_sellerconsultation_respond_form',
                                'actionName' => 'save',
                                'params' => [false],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
