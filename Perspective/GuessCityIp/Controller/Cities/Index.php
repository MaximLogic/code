<?php
namespace Perspective\GuessCityIp\Controller\Cities;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;
    /**
     * @var \Perspective\GuessCityIp\Block\Index
     */
    private $blockHelper;

    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Perspective\GuessCityIp\Block\Index $blockHelper,
        \Magento\Framework\Controller\ResultFactory $resultFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->blockHelper = $blockHelper;
        $this->resultFactory = $resultFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $pars = $this->getRequest()->getParam("city");
        
        $cityCollection = $this->blockHelper->getCityCollection();
        if($cityCollection->count() < 1)
        {
            $npCities = $this->blockHelper->getNpCities();
            $this->blockHelper->saveCities($npCities);
        }
        $cityCollection = $this->blockHelper->getCityCollection();
        $cityCollection->addFieldToFilter("city_ru", $pars);
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        foreach($cityCollection as $city)
        {
            $result->setData($city);
        }
        return $result;
    }
}
