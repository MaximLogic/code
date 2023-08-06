<?php
namespace Perspective\CancelOrder\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;

    /**
     * @var \Perspective\CancelOrder\Model\CanceledOrderFactory
     */
    private $canceledOrderFactory;

    /**
     * @var \Magento\Sales\Api\OrderManagementInterface
     */
    private $orderManagement;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Perspective\CancelOrder\Model\CanceledOrderFactory $canceledOrderFactory,
        \Magento\Sales\Api\OrderManagementInterface $orderManagement,
        array $data = []
    ) {
        $this->request = $request;
        $this->orderRepository = $orderRepository;
        $this->customerSession = $customerSession;
        $this->messageManager = $messageManager;
        $this->canceledOrderFactory = $canceledOrderFactory;
        $this->orderManagement = $orderManagement;
        parent::__construct($context, $data);
    }

    public function cancelOrder()
    {
        $pars = $this->request->getParams();
        $order = null;
        try
        {
            $order = $this->orderRepository->get($pars['order-id']);
        }
        catch(\Exception $e)
        {
            $this->messageManager->addErrorMessage('Something went wrong.');
        }
        $currentCustomerId = $this->customerSession->getCustomer()->getId();
        if($order && $order->getStatus() == 'pending' && $order->getCustomerId() == $currentCustomerId)
        {
            $cancellationReasons = [
                'alt' => 'I found a cheaper alternative',
                'dupl' => 'I placed a duplicate order',
                'del' => 'Delivery takes to long',
                'wrng' => 'I bought the wrong item(s)',
                'nfb' => 'I recieved negative feedback about the item after purchase',
                'lse' => 'Else'
            ];

            $customerName = $this->customerSession->getCustomer()->getFirstname() 
            . ' ' . $this->customerSession->getCustomer()->getLastname();

            $canceledOrder = $this->canceledOrderFactory->create();
            $canceledOrder->setOrderId($pars['order-id'])
                          ->setCancReason($cancellationReasons[$pars['canc-reason']])
                          ->setComment($pars['canc-comment'])
                          ->setCancelledBy($customerName);
            $canceledOrder->save();
            $this->orderManagement->cancel($pars['order-id']);
            $this->messageManager->addSuccessMessage('Succesfully canceled order.');

        }
        else
        {
            $this->messageManager->addErrorMessage('Something went wrong.');
        }
    }
}
