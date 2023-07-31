<?php
namespace Perspective\CustomProductPrice\Ui\DataProvider\Product\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Element\Checkbox;

class AllowModify implements ModifierInterface
{
    public function modifyMeta(array $meta)
    {
        $meta['product-details']['children']['container_p_custom_price']['children']['p_allow_modify'] = 
        [
            'arguments' => [
                'data' => [
                    'config' => [
                        'formElement' => Checkbox::NAME,
                        'componentType' => Field::NAME,
                        'visible' => 1,
                        'dataScope' => 'allowModify',
                        'description' => __('Allow Modify'),
                        'valueMap' => [
                            'false' => '0',
                            'true' => '1',
                        ]
                    ]
                ]
            ]
        ];

        return $meta;
    }

    public function modifyData(array $data)
    {
        return $data;
    }
}