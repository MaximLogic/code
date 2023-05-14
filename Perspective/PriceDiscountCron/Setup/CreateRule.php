<?php
namespace Perspective\PriceDiscountCron\Setup;

use Exception;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class CreateRule implements InstallDataInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var \Magento\CatalogRule\Model\RuleFactory
     */
    private $ruleFactory;

    /**
    /**
     * @var \Magento\CatalogRule\Model\CatalogRuleRepository
     */
    private $catalogRuleRepository;

    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        \Magento\CatalogRule\Model\RuleFactory $ruleFactory,
        \Magento\CatalogRule\Model\CatalogRuleRepository $catalogRuleRepository
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
        $this->catalogRuleRepository = $catalogRuleRepository;
        
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->moduleDataSetup->startSetup();
        
        $rule = $this->ruleFactory->create()
        ->setName('PriceDiscountCron Rule')
        ->setDescription('Rule from Price Discount Module')
        ->setIsActive(0) 
        ->setCustomerGroupIds(array(1))
        ->setWebsiteIds(array(1)) 
        ->setFromDate('') 
        ->setToDate('') 
        ->setSimpleAction('by_percent') 
        ->setDiscountAmount(10) 
        ->setStopRulesProcessing(0);

        try {
            $this->catalogRuleRepository->save($rule);
        } catch (Exception $e) {                    
           echo $e->getMessage();
        }

        $this->moduleDataSetup->endSetup();
    }
}