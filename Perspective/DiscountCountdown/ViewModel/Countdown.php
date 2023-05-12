<?php
namespace Perspective\DiscountCountdown\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Countdown implements ArgumentInterface
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    private $timezone;

    /**
     * @var \Magento\CatalogRule\Model\ResourceModel\Rule
     */
    private $ruleResource;

    public function __construct(
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \Magento\CatalogRule\Model\ResourceModel\Rule $ruleResource
    )
    {
        $this->timezone = $timezone;
        $this->ruleResource = $ruleResource;
    }

    public function getCurrentTimeStamp()
    {
        return $this->timezone->scopeTimeStamp();
    }

    public function getCurrentDateTime()
    {
        return $this->timezone->date()->format('Y-m-d H:i:s');
    }

    public function getRules($date, $productId, $websiteId = 1, $customerGroupId = 0)
    {
        return $this->ruleResource->getRulesFromProduct($date, $websiteId, $customerGroupId, $productId);
    }
}
