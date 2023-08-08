<?php
namespace Perspective\OneClickPurchase\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class CreateOrder implements ArgumentInterface
{
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     * @var \Magento\Sales\Api\OrderManagementInterface
     */
    private $messageManager;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    private $customerCollectionFactory;

    /**
     * @var \Magento\Customer\Api\AddressRepositoryInterface
     */
    private $addressRepository;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $productRepository;

    /**
     * @var \Magento\ConfigurableProduct\Model\Product\Type\Configurable
     */
    private $configurableProductTypeModel;

    /**
     * @var \Magento\Quote\Model\QuoteFactory
     */
    private $quoteFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Quote\Model\QuoteManagement
     */
    private $quoteManagement;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    private $customerFactory;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepository;

    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurableProductTypeModel,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Quote\Model\QuoteManagement $quoteManagement,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
    )
    {
        $this->messageManager = $messageManager;
        $this->request = $request;
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->addressRepository = $addressRepository;
        $this->productRepository = $productRepository;
        $this->configurableProductTypeModel = $configurableProductTypeModel;
        $this->quoteFactory = $quoteFactory;
        $this->storeManager = $storeManager;
        $this->quoteManagement = $quoteManagement;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
    }

    public function createOrder()
    {
        $params = $this->request->getParams();
        if(($params['product-size-attribute-id'] && !$params['product-size']) 
        || ($params['product-color-attribute-id']) && !$params['product-color'])
        {
            $this->messageManager->addErrorMessage('Please select product size and color');
        }
        else if($params['product-qty'] < 1)
        {
            $this->messageManager->addErrorMessage('Product qty can\'t be less than 1');
        }
        else
        {
            if(empty($params['firstname'])) $params['firstname'] = null;
            if(empty($params['lastname'])) $params['lastname'] = null;
            if(empty($params['phone'])) $params['phone'] = null;

            $customerCollection = $this->customerCollectionFactory->create();
            $customerCollection->addAttributeToFilter('email', ['eq' => $params['email']]);
            $customer = null;
            $order = [];
            foreach($customerCollection as $key => $value)
            {
                $customer = $value;
            }
            if($customer)
            {
                $billingAddress = $this->addressRepository->getById($customer->getDefaultBilling());
                $order = [
                    'currency_id' => 'USD',
                    'email' => $params['email'],
                    'shipping_address' => [
                        'firstname' => $params['firstname'] ?? $customer->getFirstname() ?? 'John',
                        'lastname' => $params['lastname'] ?? $customer->getLastname() ?? 'Doe',
                        'street' => $billingAddress->getStreet()[0] ?? '1 st.',
                        'city' => $billingAddress->getCity() ?? 'New York',
                        'country_id' => $billingAddress->getCountryId() ?? 'US',
                        'region' => $billingAddress->getRegion()->getRegion() ?? 'NY',
                        'postcode' => $billingAddress->getPostcode() ?? '85001',
                        'telephone' => $params['phone'] ?? $billingAddress->getTelephone() ?? '(099) 000-0000',
                        'fax' => '3242322556',
                        'save_in_address_book' => 1
                    ]
                ];
            }
            else
            {
                $order = [
                    'currency_id' => 'USD',
                    'email' => $params['email'],
                    'shipping_address' => [
                        'firstname' => $params['firstname'] ?? 'John',
                        'lastname' => $params['lastname'] ?? 'Doe',
                        'street' => '1 st.',
                        'city' => 'New York',
                        'country_id' => 'US',
                        'region' => 'NY',
                        'postcode' => '85001',
                        'telephone' => $params['phone'] ?? '(099) 000-0000',
                        'fax' => '3242322556',
                        'save_in_address_book' => 1
                    ]
                ];
            }

            if($params['product-size'] && $params['product-color'])
            {
                $orderedProduct = $this->productRepository->getById($params['product-id']);
                $attributesInfo = [
                    $params['product-size-attribute-id'] => $params['product-size'],
                    $params['product-color-attribute-id'] => $params['product-color']
                ];
                $associateProduct = $this->configurableProductTypeModel->getProductByAttributes($attributesInfo, $orderedProduct);
                $order['items'] = [
                    ['product_id' => $associateProduct->getId(), 'qty' => $params['product-qty']]
                ];
            }
            else
            {
                $order['items'] = [
                    ['product_id' => $params['product-id'], 'qty' => $params['product-qty']]
                ];
            }


            $store = $this->storeManager->getStore();
            $websiteId = $this->storeManager->getStore()->getWebsiteId();

            $quote = $this->quoteFactory->create();
            $quote->setStore($store);
            $quote->setCurrency();

            if(!$customer)
            {
                $customer = $this->customerFactory->create();
                $customer->setWebsiteId($websiteId)
                         ->setStore($store)
                         ->setFirstname($order['shipping_address']['firstname'])
                         ->setLastname($order['shipping_address']['lastname'])
                         ->setEmail($order['email'])
                         ->setPassword($order['email']);
                $customer->save();
            }
            $customer = $this->customerRepository->getById($customer->getEntityId());
            $quote->assignCustomer($customer);

            $product = $this->productRepository->getById($order['items'][0]['product_id']);
            $quote->addProduct($product, $order['items'][0]['qty']);

            $quote->getBillingAddress()->addData($order['shipping_address']);
            $quote->getShippingAddress()->addData($order['shipping_address']);

            $shippingAddress = $quote->getShippingAddress();
            $shippingAddress->setCollectShippingRates(true)->collectShippingRates()->setShippingMethod('freeshipping_freeshipping');
            $quote->setPaymentMethod('checkmo');

            $quote->setInventoryProcessed(false);
            $quote->save();
            
            $quote->getPayment()->importData(['method' => 'checkmo']);
            $quote->collectTotals()->save();

            $orderdata = $this->quoteManagement->submit($quote);

            $this->messageManager->addSuccessMessage('Succesfully created order.');

        }
    }
}
