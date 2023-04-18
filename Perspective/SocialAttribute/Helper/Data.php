<?php
namespace Perspective\SocialAttribute\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends AbstractHelper
{
    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);
    }

    public function isEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'socialconf/general/enable', 
            $scope
        );
    }

    public function getDiscount($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if($this->isEnabled())
        {
            return $this->scopeConfig->getValue('socialconf/general/discount', $scope);
        }
        return null;
    }
}
