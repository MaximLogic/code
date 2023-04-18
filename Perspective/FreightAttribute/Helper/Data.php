<?php
namespace Perspective\FreightAttribute\Helper;

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
            'freightconf/general/enable', 
            $scope
        );
    }
    
    public function getBaloonMax($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if($this->isEnabled())
        {
            return $this->scopeConfig->getValue('freightconf/general/baloon_max', $scope);
        }
        return null;
    }
    public function getBaloonMargin($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if($this->isEnabled())
        {
            return $this->scopeConfig->getValue('freightconf/general/baloon_margin', $scope);
        }
        return null;
    }

    public function getCharterPlaneMax($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if($this->isEnabled())
        {
            return $this->scopeConfig->getValue('freightconf/general/charterplane_max', $scope);
        }
        return null;
    }
    public function getCharterPlaneMargin($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if($this->isEnabled())
        {
            return $this->scopeConfig->getValue('freightconf/general/charterplane_margin', $scope);
        }
        return null;
    }

    public function getHighspeedPlaneMax($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if($this->isEnabled())
        {
            return $this->scopeConfig->getValue('freightconf/general/highspeedplane_max', $scope);
        }
        return null;
    }
    public function getHighspeedPlaneMargin($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if($this->isEnabled())
        {
            return $this->scopeConfig->getValue('freightconf/general/highspeedplane_margin', $scope);
        }
        return null;
    }

    public function getSpaceshipMax($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if($this->isEnabled())
        {
            return $this->scopeConfig->getValue('freightconf/general/spaceship_max', $scope);
        }
        return null;
    }
    public function getSpaceshipMargin($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if($this->isEnabled())
        {
            return $this->scopeConfig->getValue('freightconf/general/spaceship_margin', $scope);
        }
        return null;
    }
}
