<?php
namespace Perspective\CustomerAvatar\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class AvatarTypes implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'image/jpeg', 'label' => __('.jpeg, .jpg')],
            ['value' => 'image/png', 'label' => __('.png')],
            ['value' => 'image/gif', 'label' => __('.gif')]
        ];
    }
}
