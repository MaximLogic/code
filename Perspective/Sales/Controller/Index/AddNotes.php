<?php
namespace Perspective\Sales\Controller\Index;

class AddNotes extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Perspective\Sales\Model\SalesFactory
     */
    private $_salesFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
        \Perspective\Sales\Model\SalesFactory $_salesFactory
    )
    {
        $this->_salesFactory = $_salesFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = [
            ["Juno Jacket", 10, "2022-07-07", 100, 0.05],
            ["Pierce Gym Short", 2, "2022-06-06", 30, 0.2]
        ];

        foreach($data as $item)
        {
            $sales = $this->_salesFactory->create();

            $sales->setProduct($item[0])
                  ->setCount($item[1])
                  ->setDate($item[2])
                  ->setPrice($item[3])
                  ->setBonus($item[4]);

            $sales->save();
        }

        echo "Succesfull!";
    }
}
