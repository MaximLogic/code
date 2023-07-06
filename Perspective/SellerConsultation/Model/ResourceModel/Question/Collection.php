<?php
namespace Perspective\SellerConsultation\Model\ResourceModel\Question;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'question_id';
    protected $_eventPrefix = 'perspective_sellerconsultation_question_collection';
    protected $_eventObject = 'question_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Perspective\SellerConsultation\Model\Question', 'Perspective\SellerConsultation\Model\ResourceModel\Question');
    }
}
