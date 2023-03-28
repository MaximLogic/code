<?php
namespace Perspective\SystemConfigExample\Block;

class Config extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Perspective\SystemConfigExample\Helper\Data
     */
    private $_helperData;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Perspective\SystemConfigExample\Helper\Data $_helperData,
        array $data = []
    ) 
    {
        $this->_helperData = $_helperData;
        parent::__construct($context, $data);
    }

    public function isEnabled()
    {
        return $this->_helperData->isEnabled();
    }

    public function getTitle()
    {
        return $this->_helperData->getTitle();
    }

    public function getSecret()
    {
        return $this->_helperData->getSecret();
    }

    public function getOption()
    {
        return $this->_helperData->getOption();
    }
}
