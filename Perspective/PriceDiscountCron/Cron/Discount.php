<?php
namespace Perspective\PriceDiscountCron\Cron;

use Exception;

class Discount
{
    /**
     * @var \Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory
     */
    private $ruleCollectionFactory;
    public function __construct(
        \Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory $ruleCollectionFactory
    )
    {
        $this->ruleCollectionFactory = $ruleCollectionFactory;
    }

    public function execute()
    {
        $ruleName = 'PriceDiscountCron Rule';
        $rules = $this->ruleCollectionFactory->create()
            ->addFieldToFilter('name', ['eq' => $ruleName]);
        foreach($rules as $rule)
        {
                $ruleActive = $rule->getIsActive();
                $rule->setIsActive($ruleActive ? 0 : 1);
                $rule->save();
        }
    }
}
