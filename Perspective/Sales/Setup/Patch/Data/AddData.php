<?php
namespace Perspective\Sales\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

class AddData implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $_moduleDataSetup;

    /**
     * @var \Perspective\Sales\Model\SalesFactory
     */
    private $_salesFactory;

    /**
     * @var \Perspective\Sales\Model\ResourceModel\Sales
     */
    private $_salesResource;

    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $_moduleDataSetup,
        \Perspective\Sales\Model\SalesFactory $_salesFactory,
        \Perspective\Sales\Model\ResourceModel\Sales $_salesResource
    )
    {
        $this->_moduleDataSetup = $_moduleDataSetup;
        $this->_salesFactory = $_salesFactory;
        $this->_salesResource = $_salesResource;   
    }
    public function apply()
    {
        $sales = [
            ['Juno Jacket', 5, '2022-12-12', 0.1],
            ['Cronus Yoga Pant', 10, '2022-11-11', 0.05],
            ['Pierce Gym Short', 3, '2022-10-10', 0.2],
            ['Erika Running Short', 9, '2022-9-9', 0.05],
            ['Juno Jacket', 5, '2023-03-18', 0.1]
        ];
        $this->_moduleDataSetup->startSetup();

        foreach($sales as $item)
        {
            $product = $item[0];
            $count = $item[1];
            $date = $item[2];
            $discount = $item[3];
            $sale=$this->_salesFactory->create();
            $sale->setProduct($product)
                 ->setCount($count)
                 ->setDate($date)
                 ->setDiscount($discount);
            $this->_salesResource->save($sale);
        }
        $this->_moduleDataSetup->endSetup();
    }
    public static function getDependencies()
    {
        return [];
    }
    public static function getVersion()
    {
        return '1.0.1';
    }
    public function getAliases()
    {
        return [];
    }
}
