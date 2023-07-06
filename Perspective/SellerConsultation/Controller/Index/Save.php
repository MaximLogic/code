<?php
namespace Perspective\SellerConsultation\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @var \Perspective\SellerConsultation\Model\QuestionFactory
     */
    private $questionFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Perspective\SellerConsultation\Model\QuestionFactory $questionFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->questionFactory = $questionFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = (array)$this->getRequest()->getPost();
        if ($data) {
            try
            {
                $model = $this->questionFactory->create();
                $model->setData($data)->save();
                $this->messageManager->addSuccessMessage(__("Submitted succesfully."));
            }
            catch(\Exception $e)
            {
                $this->messageManager->addErrorMessage($e, __("Something went wrong..."));
            }
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}
