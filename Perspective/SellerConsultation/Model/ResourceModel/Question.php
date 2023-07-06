<?php
namespace Perspective\SellerConsultation\Model\ResourceModel;

class Question extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('perspective_sellerconsultation_question', 'question_id');
    }
}
