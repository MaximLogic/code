<?php
namespace Perspective\SellerConsultation\Controller\adminhtml\Question;

class Delete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Perspective\SellerConsultation\Model\QuestionFactory
     */
    private $questionFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
        \Perspective\SellerConsultation\Model\QuestionFactory $questionFactory
    )
    {
        parent::__construct($context);
        $this->questionFactory = $questionFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('question_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) 
        {
            try
            {
                $model = $this->questionFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Record deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            }
            catch(\Exception $e)
            {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addError(__('Record does not exist.'));
        return $resultRedirect->setPath('*/*/');
    }
}
