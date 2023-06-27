<?php
namespace Perspective\CustomPayment\Model\Source;

use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Payment\Model\Config;

class PaymentMethods extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var Config
     */
    protected $paymentModelConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Config $paymentModelConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->paymentModelConfig = $paymentModelConfig;
    }

    public function getAllOptions()
    {
        $payments = $this->paymentModelConfig->getActiveMethods();
        $methods = array();
        foreach ($payments as $paymentCode => $paymentModel) {
            $paymentTitle = $this->scopeConfig
                ->getValue('payment/'.$paymentCode.'/title');
            $methods[$paymentCode] = array(
                'label' => $paymentTitle,
                'value' => $paymentCode
            );
        }
        return $methods;
    }
}
