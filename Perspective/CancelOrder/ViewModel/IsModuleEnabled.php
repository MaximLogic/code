<?php
namespace Perspective\CancelOrder\ViewModel;

class IsModuleEnabled implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
        
    }

    public function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag('cancelorderconf/general/enable');
    }
}
