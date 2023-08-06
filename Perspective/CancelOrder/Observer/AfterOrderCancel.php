<?php
namespace Perspective\CancelOrder\Observer;

class AfterOrderCancel implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Perspective\CancelOrder\Model\CanceledOrderFactory
     */
    private $canceledOrderFactory;

    public function __construct(
        \Perspective\CancelOrder\Model\CanceledOrderFactory $canceledOrderFactory
    )
    {
        $this->canceledOrderFactory = $canceledOrderFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getOrder();
        $canceledOrder = $this->canceledOrderFactory->create();
        $canceledOrder->setOrderId($order->getIncrementId())
                      ->setCancReason('Canceled by Admin')
                      ->setCancelledBy('Admin')
                      ->save();
    }
}