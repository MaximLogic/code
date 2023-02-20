<?php
namespace Products\GetProductsRuleId\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $_productRepository;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $_productCollectionFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        array $data = []
    ) 
    {
        $this->_productRepository = $productRepository;
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getProductById($productId)
    {
        if (is_null($productId)){
            return null;
        }
        $productModel = $this->_productRepository->getById($productId);
        return $productModel;
    }

    public function getProductsByCatalogRuleId($catalogRuleId)
    {   
        $storeManager = \Magento\Framework\App\ObjectManager::getInstance()->create(
            '\Magento\Store\Model\StoreManagerInterface'
        );
        $catalogRule = \Magento\Framework\App\ObjectManager::getInstance()->create(
            '\Magento\CatalogRule\Model\RuleFactory'
        );
        $websiteId = $storeManager->getStore()->getWebsiteId();
        $resultProductIds = [];
        $resultProductSkus = [];
        $catalogRuleCollection = $catalogRule->create()->getCollection();
        $catalogRuleCollection->addIsActiveFilter(1);
        
        foreach ($catalogRuleCollection as $catalogRule) {
            if($catalogRule->getRuleId() == $catalogRuleId){
                $productIdsAccToRule = $catalogRule->getMatchingProductIds();
                foreach ($productIdsAccToRule as $productId => $ruleProductArray) {
                    if (!empty($ruleProductArray[$websiteId])) {
                        $resultProductIds[] = $productId;
                    }
                }
            }
        }

        foreach($resultProductIds as $id){
            $product = $this->getProductById($id);
            $resultProductSkus[] = $product->getSku();
        }

        $productCollection = $this->_productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->setPageSize(10);
        $productCollection->addAttributeToFilter('sku', array('in' => $resultProductSkus));
        return $productCollection;
    }
}
