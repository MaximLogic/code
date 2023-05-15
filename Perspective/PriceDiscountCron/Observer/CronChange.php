<?php
namespace Perspective\PriceDiscountCron\Observer;

use Exception;

class CronChange implements \Magento\Framework\Event\ObserverInterface
{

    const CRON_STRING_PATH = 'crontab/default/jobs/price_discount_cron/schedule/cron_expr';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;
    
    /**
     * @var \Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory
     */
    private $ruleCollectionFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\Timezone
     */
    private $timezone;

    /**
     * @var \Magento\Framework\App\Config\ValueFactory
     */
    private $configValueFactory;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory $ruleCollectionFactory,
        \Magento\Framework\Stdlib\DateTime\Timezone $timezone,
        \Magento\Framework\App\Config\ValueFactory $configValueFactory
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
        $this->timezone = $timezone;
        $this->configValueFactory = $configValueFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $moduleEnable = $this->scopeConfig->getValue('pricesdiscountconf/general/enable');

        if($moduleEnable)
        {
            $ruleName = 'PriceDiscountCron Rule';
            $rules = $this->ruleCollectionFactory->create()
                ->addFieldToFilter('name', ['eq' => $ruleName]);
            
            $cronFrom = $this->scopeConfig->getValue('pricesdiscountconf/general/from');
            $cronTo = $this->scopeConfig->getValue('pricesdiscountconf/general/to');
            $cronFromArr = explode(',', $cronFrom);
            $cronToArr = explode(',', $cronTo);
            $cronFromHour = (int)$cronFromArr[0];
            $cronToHour = (int)$cronToArr[0];

            if($cronFromHour >= $cronToHour)
            {
                throw new Exception('From Time needs to be less than To Time');
            }
            else
            {
                $newCronExpr = "0 $cronFromHour,$cronToHour * * *";

                $this->configValueFactory->create()->load(self::CRON_STRING_PATH, 'path')
                ->setValue($newCronExpr)
                ->setPath(self::CRON_STRING_PATH)
                ->save();

                $discount = (int)$this->scopeConfig->getValue('pricesdiscountconf/general/discount');
                $customerGroupIds = explode(',', $this->scopeConfig->getValue('pricesdiscountconf/general/customergroup'));
                $categoryIds = $this->scopeConfig->getValue('pricesdiscountconf/general/categories');

                
                foreach($rules as $rule)
                {
                    $currentHour = (int)$this->timezone->date()->format('H');
                    $ruleEnable = $currentHour > $cronFromHour && $currentHour < $cronToHour ? 1 : 0;
                    $condition = json_decode($rule->getData('conditions_serialized'), true);
                    $condition['conditions'][0]['value'] = $categoryIds;

                    $rule->setDiscountAmount($discount)
                        ->setCustomerGroupIds($customerGroupIds)
                        ->setIsActive($ruleEnable);
                    $rule->setData('conditions_serialized', json_encode($condition));
                    $rule->save();
                }
            }
        }
    }
}