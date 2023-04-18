<?php
namespace Perspective\FreightAttribute\Model\Attribute\Source;

class FreightType extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions()
    {
        if (!$this->_options) 
        {
            $this->_options = [
                ['label' => __('None'), 'value' => 'none'],
                ['label' => __('Balloon'), 'value' => 'baloon'],
                ['label' => __('Charter plane'), 'value' => 'charter_plane'],
                ['label' => __('High-speed plane'), 'value' => 'high_speed_plane'],
                ['label' => __('Spaceship'), 'value' => 'spaceship']
            ];
        }
        
        return $this->_options;
    }
}
