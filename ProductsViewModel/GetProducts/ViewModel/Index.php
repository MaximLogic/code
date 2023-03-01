<?php
namespace ProductsViewModel\GetProducts\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Index implements ArgumentInterface
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $_productRepository;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    private $_productImageHelper;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    private $_customerCollectionFactory;

    /**
     * @var \Magento\Reports\Model\ResourceModel\Order\CollectionFactory
     */
    private $_orderCollectionFactory;

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

    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Helper\Image $productImageHelper,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        \Magento\Reports\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Sales\Model\Order\Config $orderConfig,
        \Magento\Customer\Model\ResourceModel\Group\CollectionFactory $groupCollectionFactory,
        \Magento\Payment\Model\PaymentMethodList $paymentMethodList,
        \Magento\Shipping\Model\Config\Source\Allmethods $shippingMethods
    )
    {
        $this->_productRepository = $productRepository;
        $this->_productImageHelper = $productImageHelper;
        $this->_customerCollectionFactory = $customerCollectionFactory;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->_orderConfig = $orderConfig;
        $this->_groupCollectionFactory = $groupCollectionFactory;
        $this->_paymentMethodList = $paymentMethodList;
        $this->_shippingMethods = $shippingMethods;
        
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
