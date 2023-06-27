<?php
namespace Perspective\CustomPayment\Setup;

use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
 
class InstallData implements InstallDataInterface
{
    protected $groupFactory;
 
    public function __construct() 
    {

    }
 
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) 
    {
        $setup->startSetup();
 
        $setup->getConnection()->insertForce(
            $setup->getTable('customer_group'),
            ['customer_group_code' => 'Opt', 'tax_class_id' => 3]
        );
        $setup->getConnection()->insertForce(
            $setup->getTable('customer_group'),
            ['customer_group_code' => 'Big Opt', 'tax_class_id' => 3]
        );
 
        $setup->endSetup();
    }
}