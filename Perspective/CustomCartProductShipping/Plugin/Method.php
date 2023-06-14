<?php
namespace Perspective\CustomCartProductShipping\Plugin;

class Method 
{
    public function afterCollectRates(\Magento\Shipping\Model\Carrier\AbstractCarrier $subject, $result)
    {
        if($result != false) 
        {
            $rates = $result->getRatesByCarrier('customshipping') ?? null;
            foreach ($rates as $rate)
            {
                $price = $rate->getPrice();
                if ($price < 2) {
                    $price = 2;
                }
                $rate->setPrice($price);
            }
        }
        
        return $result;
    }
}