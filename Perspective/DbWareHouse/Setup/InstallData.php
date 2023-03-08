<?php
namespace Perspective\DbWareHouse\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    protected $_postFactory;

    public function __construct(\Perspective\DbWareHouse\Model\PostFactory $postFactory)
    {
        $this->_postFactory = $postFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $data = [
            'name_war' => "Warehouse 1",
            'addr_war' => "вул. Лесі Українки 53",
            'id_cat' => "23",
            'id_prod' => "1380",
            'kol_prod' => 150,
            'data_prod' => "2023-01-01"
        ];
        
        $post = $this->_postFactory->create();
        $post->addData($data)->save();
    }
}