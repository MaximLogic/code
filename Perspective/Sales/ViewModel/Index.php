<?php
namespace Perspective\Sales\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Index implements ArgumentInterface
{
    /**
     * @var \Perspective\Sales\Model\SalesFactory
     */
    private $_salesFactory;

    /**
     * @var \Perspective\Sales\Model\ResourceModel\Sales\CollectionFactory
     */
    private $_salesCollectionFactory;

    public function __construct(
        \Perspective\Sales\Model\SalesFactory $_salesFactory,
        \Perspective\Sales\Model\ResourceModel\Sales\CollectionFactory $_salesCollectionFactory
    )
    {
        $this->_salesFactory = $_salesFactory;
        $this->_salesCollectionFactory = $_salesCollectionFactory;
    }

    public function updateData(){
        $prices = [1 => 100, 2 => 150, 3 => 50, 4 => 200, 5 => 25];
    
        foreach($prices as $id => $price)
        {
            $sales = $this->_salesFactory->create();

            $sales->load($id);

            $sales->setPrice($price);

            $sales->save();
        }
    }

    public function getPriceByName($productName)
    {
        $collection = [];

        $salesCollection = $this->_salesCollectionFactory
        ->create()
        ->addFieldToSelect("*")
        ->addFieldToFilter("product", ["eq" => $productName]);

        foreach($salesCollection as $sale)
        {
            $curdate = date("Y-m-d");
            
            if($sale["date"] == $curdate)
            {
                $collection[] = [
                    "name" => $sale["product"],
                    "price" => $sale["price"] * $sale["count"] * (1 - $sale["bonus"]),
                    "date" => $sale["date"]
                ];
            }
            else
            {
                $collection[] = [
                    "name" => $sale["product"],
                    "price" => $sale["price"] * $sale["count"],
                    "date" => $sale["date"]
                ];
            }
        }

        return $collection;
    }
}
