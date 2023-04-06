<?php
namespace Perspective\CurrencyConfig\Helper;

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
            'currencyconf/general/enable', 
            $scope
        );
    }

    public function isUahEnabled(
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT
    )
    {
        return $this->scopeConfig->isSetFlag('currencyconf/general/uah_enable', $scope);
    }

    public function isRubEnabled(
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT
    )
    {
        return $this->scopeConfig->isSetFlag('currencyconf/general/rub_enable', $scope);
    }

    public function isEuroEnabled(
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT
    )
    {
        return $this->scopeConfig->isSetFlag('currencyconf/general/euro_enable', $scope);
    }

    public function getUahCourse(
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT
    )
    {
        if($this->isUahEnabled())
        {
            return $this->scopeConfig->getValue('currencyconf/general/uah_course', $scope);
        }
        return null;
    }

    public function getRubCourse(
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT
    )
    {
        if($this->isRubEnabled())
        {
            return $this->scopeConfig->getValue('currencyconf/general/rub_course', $scope);
        }
        return null;
    }

    public function getEuroCourse(
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT
    )
    {
        if($this->isEuroEnabled())
        {
            return $this->scopeConfig->getValue('currencyconf/general/euro_course', $scope);
        }
        return null;
    }
}
