<?php
namespace Perspective\PriceDiscountCron\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateRule implements DataPatchInterface
{
    /**
     * @var \Magento\CatalogRule\Model\RuleFactory
     */
    private $ruleFactory;

    /**
     * @var \Magento\CatalogRule\Api\Data\RuleInterfaceFactory
     */
    private $ruleDataFactory;

    /**
     * @var \Magento\Framework\App\State
     */
    private $appState;

    public function __construct(
        \Magento\CatalogRule\Model\RuleFactory $ruleFactory,
        \Magento\CatalogRule\Api\Data\RuleInterfaceFactory $ruleDataFactory,
        \Magento\Framework\App\State $appState
    )
    {
        $this->ruleFactory = $ruleFactory;
        $this->ruleDataFactory = $ruleDataFactory;
        $this->appState = $appState;
    }

    public function apply()
    {
        $this->appState->setAreaCode('adminhtml');
        $ruleData = [
            'name' => 'PriceDiscountCron Rule',
            'description' => 'Rule from Price Discount Module',
            'is_active' => 0,
            'website_ids' => [1],
            'customer_group_ids' => [1],
            'from_date' => '',
            'to_date' => '',
            'simple_action' => 'by_percent',
            'discount_amount' => 0
        ];

        $rule = $this->ruleFactory->create();

        $ruleDataObject = $this->ruleDataFactory->create(['data' => $ruleData]);
        $rule->setData($ruleDataObject->getData());   
        $rule->save();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [];
    }
}
