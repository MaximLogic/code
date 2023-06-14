<?php
namespace Perspective\CustomCartProductShipping\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;

class Customshipping extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements \Magento\Shipping\Model\Carrier\CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'customshipping';

    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    private $rateResultFactory;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    private $rateMethodFactory;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $session;

    private $customerSession;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Magento\Checkout\Model\Session $session,
        array $data = []
    ) {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);

        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->session = $session;
        $this->customerSession = \Magento\Framework\App\ObjectManager::getInstance()->get(\Magento\Customer\Model\Session::class);
    }

    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        if(!$this->customerSession->isLoggedIn()){
            return false;
        }
        $customerDob = $this->customerSession->getCustomer()->getDob();
        if($customerDob != null){
            $now = new \DateTime();
            $dob = new \DateTime($customerDob);
            $diff = $now->diff($dob);
            $years = $diff->y;
            if($years < 60){
                return false;
            }
        }

        $cartProducts = $request->getAllItems();

        $categoryIds = array_map('intval', explode(',', $this->getConfigData('categories')));
        foreach($cartProducts as $item){
            $product = $item->getProduct();
            $productCategoryIds = $product->getCategoryIds();
            if(count(array_intersect($categoryIds, $productCategoryIds)) == 0){
                return false;
            }
        }

        $result = $this->rateResultFactory->create();

        $method = $this->rateMethodFactory->create();

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));

        $shippingCost = (float)$this->getConfigData('shipping_cost');

        $productsCount = 0;
        foreach($cartProducts as $product){
            $productsCount += $product->getQty();
        }

        if($productsCount < 3){
            $method->setPrice($shippingCost);
            $method->setCost($shippingCost);
        }
        else if($productsCount <= 5){
            $method->setPrice(0.5 * $shippingCost);
            $method->setCost(0.5 * $shippingCost);
        }
        else if($productsCount <= 10){
            $method->setPrice(0.2 * $shippingCost);
            $method->setCost(0.2 * $shippingCost);
        }
        else{
            $method->setPrice(0);
            $method->setCost(0);
        }

        $result->append($method);

        return $result;
    }

    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }

}
