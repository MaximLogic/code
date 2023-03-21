<?php
namespace Perspective\Sales\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;

class AddColumn implements SchemaPatchInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $_moduleDataSetup;

    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $_moduleDataSetup
    )
    {
        $this->_moduleDataSetup = $_moduleDataSetup;
    }

    public static function getDependencies()
    {
        return [];
    }
    public function getAliases()
    {
        return [];
    }
    public function apply()
    {
        $this->_moduleDataSetup->startSetup();

        $this->_moduleDataSetup->getConnection()->addColumn(
            $this->_moduleDataSetup->getTable('perspective_sales'),
            'price',
            [
                'type' => Table::TYPE_INTEGER,
                'padding' => 11,
                'nullable' => false,
                'unsigned' => true,
                'comment' => 'Price',
            ]
        );

        $this->_moduleDataSetup->endSetup();
    }
}
