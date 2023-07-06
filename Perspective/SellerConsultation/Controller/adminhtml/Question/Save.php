<?php
namespace Perspective\SellerConsultation\Controller\adminhtml\Question;

use Magento\Backend\Model\Session;
use Perspective\SellerConsultation\Model\Question;

class Save extends \Magento\Framework\App\Action\Action
{

    protected $adminsession;

    protected $questionModel;

    private $logger;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       Question $questionModel,
       Session $adminsession
    )
    {
        parent::__construct($context);
        $this->questionModel = $questionModel;
        $this->adminsession = $adminsession;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data)
        {
            $question_id = $this->getRequest()->getParam('question_id');
            if($question_id)
            {
                $this->questionModel->load($question_id);
            }

            $this->questionModel->setData($data);

            $emailHelper = $this->_objectManager->create('Perspective\SellerConsultation\Helper\Email');
            $this->logger = $this->_objectManager->create('Psr\Log\LoggerInterface');
            try
            {
                $this->questionModel->save();
                $emailHelper->sendEmail(
                    $this->questionModel->getName(),
                    $this->questionModel->getSubject(),
                    $question_id,
                    $this->questionModel->getEmail(),
                    $this->questionModel->getQuestionText(),
                    $this->questionModel->getAnswer(),
                    $this->questionModel->getProductId()
                );
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->adminsession->setFormData(false);
                return $resultRedirect->setPath('*/*/');
            }
            catch(\Exception $e)
            {
                $this->messageManager->addError($e->getMessage());
                $this->logger->debug($e->getMessage());
            }
        }
        
        return $resultRedirect->setPath('*/*/');
    }
}
