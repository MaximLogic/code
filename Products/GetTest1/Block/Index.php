<?php
namespace Products\GetTest1\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $_productCollectionFactory;

    /**
     * @var \Magento\Reports\Model\ResourceModel\Order\CollectionFactory
     */
    private $_orderCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $_productRepository;

    /**
     * @var \Magento\CatalogInventory\Api\StockStateInterface
     */
    private $_stockState;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    private $_productImageHelper;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    private $_customerCollectionFactory;

    /**
     * @var \Magento\Sales\Model\Order\Config
     */
    private $_orderConfig;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Group\CollectionFactory
     */
    private $_groupCollectionFactory;

    /**
     * @var \Magento\Payment\Model\PaymentMethodList
     */
    private $_paymentMethodList;

    /**
     * @var \Magento\Shipping\Model\Config\Source\Allmethods
     */
    private $_shippingMethods;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Reports\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\CatalogInventory\Api\StockStateInterface $stockState,
        \Magento\Catalog\Helper\Image $productImageHelper,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        \Magento\Sales\Model\Order\Config $orderConfig,
        \Magento\Customer\Model\ResourceModel\Group\CollectionFactory $groupCollectionFactory,
        \Magento\Payment\Model\PaymentMethodList $paymentMethodList,
        \Magento\Shipping\Model\Config\Source\Allmethods $shippingMethods,
        array $data = []
    )
    {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->_productRepository = $productRepository;
        $this->_stockState = $stockState;
        $this->_productImageHelper = $productImageHelper;
        $this->_customerCollectionFactory = $customerCollectionFactory;
        $this->_orderConfig = $orderConfig;
        $this->_groupCollectionFactory = $groupCollectionFactory;
        $this->_paymentMethodList = $paymentMethodList;
        $this->_shippingMethods = $shippingMethods;
        parent::__construct($context, $data);
    }
    
    public function getProductStockInfo($productId)
    {
        if(is_null($productId))
        {
            return null;
        }
        $product = $this->_productRepository->getById($productId);
        $productQty = $this->_stockState->getStockQty($productId, 0);
        return [
            $product->getName(), 
            $productQty, 
            $productQty > 0 ? "Yes" : "No"
        ];
    }

    public function getProductImageInfo($productId, $imageId, $attributes = [])
    {
        if(is_null($productId))
        {
            return null;
        }
        $product = $this->_productRepository->getById($productId);
        $imageHeight = $this->_productImageHelper->init($product, $imageId, $attributes)->getHeight();
        $imageWidth = $this->_productImageHelper->init($product, $imageId, $attributes)->getWidth();
        $imageUrl = $this->_productImageHelper->init($product, $imageId, $attributes)->getUrl();
        return [
            $product->getName(), 
            $imageHeight, 
            $imageWidth, 
            $imageUrl
        ];
    }

    public function getCustomerCollection()
    {
        return $this->_customerCollectionFactory->create()
               ->addAttributeToSelect("*")
               ->load();
    }

    public function getOrderCollectionByCustomerId($customerId)
    {
       $orderCollection = $this->_orderCollectionFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter(
                'status',
                ['in' => $this->_orderConfig->getVisibleOnFrontStatuses()]
            )
            ->addAttributeToFilter(
                'customer_id', 
                ['eq' => $customerId]
            )
            ->setOrder(
                'created_at',
                'desc'
            );
        $orderCollection->setPageSize(10);
        
        return $orderCollection;
    }

    public function getCustomerGroupsCollection()
    {
        $customerGroupsCollection = $this->_groupCollectionFactory->create();
        return $customerGroupsCollection;
    }

    public function getPaymentMethodsList($websiteId)
    {
        return $this->_paymentMethodList->getList($websiteId);
    }

    public function getShippingMethodsList()
    {
        return $this->_shippingMethods->toOptionArray();
    }
}
