<?php
namespace Perspective\PriceDiscountCron\Observer;

use Exception;

class CronChange implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Magento\Cron\Model\ResourceModel\Schedule\CollectionFactory
     */
    private $scheduleCollectionFactory;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Cron\Model\ResourceModel\Schedule\CollectionFactory $scheduleCollectionFactory
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->scheduleCollectionFactory = $scheduleCollectionFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $cronFrom = $this->scopeConfig->getValue('pricesdiscountconf/general/from');
        $cronTo = $this->scopeConfig->getValue('pricesdiscountconf/general/to');
        $cronFromArr = explode(',', $cronFrom);
        $cronToArr = explode(',', $cronTo);
        $cronFromHour = (int)$cronFromArr[0];
        $cronToHour = (int)$cronToArr[0];

        if($cronFromHour >= $cronToHour)
        {
            throw new Exception("From hour need to be less than To Hour");
        }
        else
        {
            $jobCode = 'price_discount_cron';
            $scheduleCollection = $this->scheduleCollectionFactory->create()
                ->addFieldToFilter('job_code', $jobCode);
            $newCronExpr = "* $cronFromHour-$cronToHour * * *";
            foreach ($scheduleCollection as $schedule) 
            {
                $schedule->setCronExpr($newCronExpr);
                $schedule->save();
            }
        }
    }
}