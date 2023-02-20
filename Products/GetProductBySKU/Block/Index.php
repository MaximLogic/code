<?php
namespace Products\GetProductBySKU\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $_productRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = []
    ) 
    {
        $this->_productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    public function getProductBySku($sku)
    {
        if(is_null($sku))
        {
            return null;
        }
        return $this->_productRepository->get($sku);
    }
}
