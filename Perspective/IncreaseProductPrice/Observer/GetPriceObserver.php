<?php
namespace Perspective\IncreaseProductPrice\Observer;

class GetPriceObserver implements \Magento\Framework\Event\ObserverInterface
{
    public function __construct()
    {
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $productPrice = $product->getFinalPrice();
        $product->setPrice($productPrice + $productPrice * 0.2);
    }
}