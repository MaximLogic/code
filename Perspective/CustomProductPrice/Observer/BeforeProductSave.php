<?php
namespace Perspective\CustomProductPrice\Observer;

class BeforeProductSave implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->request = $request;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $params = $this->request->getParams();

        if (!empty($product))
        {
            $productId = $product->getId();
            if($productId)
            {
                if($params['product']['allowModify'] == '1')
                {
                    $product->setData('p_custom_price', $params['product']['p_custom_price']);
                }
                else
                {
                    $customPricePercent = $this->scopeConfig->getValue('customprice/general/percents') / 100 + 1;
                    $product->setData('p_custom_price', $product->getPrice() * $customPricePercent);
                }
                
            }
        }
    }
}