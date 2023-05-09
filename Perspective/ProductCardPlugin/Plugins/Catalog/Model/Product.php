<?php
namespace Perspective\ProductCardPlugin\Plugins\Catalog\Model;

class Product 
{
    public function afterGetSku(\Magento\Catalog\Model\Product $product, $res)
    {
        $sku = $product->getData('sku');
        $id = $product->getId();

        $res = $id . " - " . $sku;
        return $res;
    }
}
