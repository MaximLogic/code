<?php
namespace Perspective\CustomerAvatar\Block;

class Account extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    /**
     * @var Magento\Customer\Model\SessionFactory
     */
    private $customerSession;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Customer\Model\Customer
     */
    private $customerModel;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Customer\Model\SessionFactory $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Customer $customerModel,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->customerSession = $customerSession->create();
        $this->storeManager = $storeManager;
        $this->customerModel = $customerModel;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag('avatarconf/general/enable');
    }

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }
 
    public function getMediaUrl()
    {
        return $this->getBaseUrl() . 'pub/media/';
    }
 
    public function getCustomerImageUrl($filePath)
    {
        return $this->getMediaUrl() . 'customer' . $filePath;
    }
 
    public function getFileUrl()
    {
        $customerData = $this->customerModel->load($this->customerSession->getId());
        $url = $customerData->getData('customer_avatar');
        if (!empty($url)) {
            return $this->getCustomerImageUrl($url);
        }
        return false;
    }

    public function getAllowedAvatarTypes()
    {
        return implode(', ', explode(',', $this->scopeConfig->getValue('avatarconf/general/allowed_types')));
    }
}
