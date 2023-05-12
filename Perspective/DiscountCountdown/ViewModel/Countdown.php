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

    public function getTimeUntilEnd($product)
    {
        $currentDateTime = $this->getCurrentDateTime();
        $currentTimeStamp = $this->getCurrentTimeStamp();
        $rules = $this->getRules($currentDateTime, $product->getId());

        $minRuleToTime = INF;
        $specialToDate = $product->getSpecialToDate();

        foreach($rules as $rule)
        {
            $minRuleToTime = min($rule['to_time'], $minRuleToTime);
        }
        
        if(isset($specialToDate) && strtotime($specialToDate) > $currentTimeStamp || isset($rules))
        {
            $specialToTimeStamp = !isset($specialToDate) ? INF : strtotime($specialToDate);

            $time = min($specialToTimeStamp, $minRuleToTime);

            $timeUntilEnd = $time - $currentTimeStamp;

            return $timeUntilEnd;
        }
        return null;
    }
}