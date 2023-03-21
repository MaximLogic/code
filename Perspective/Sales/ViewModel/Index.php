<?php
namespace Perspective\Sales\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Index implements ArgumentInterface
{
    /**
     * @var \Perspective\Sales\Model\SalesFactory
     */
    private $_salesFactory;

    public function __construct(
        \Perspective\Sales\Model\SalesFactory $_salesFactory
    )
    {
        $this->_salesFactory = $_salesFactory;
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
}
