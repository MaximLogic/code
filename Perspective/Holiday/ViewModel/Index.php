<?php
namespace Perspective\Holiday\ViewModel;

class Index implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Perspective\Holiday\Model\ResourceModel\Holiday\CollectionFactory
     */
    private $holidayCollectionFactory;

    public function __construct(
        \Perspective\Holiday\Model\ResourceModel\Holiday\CollectionFactory $holidayCollectionFactory
    )
    {
        $this->holidayCollectionFactory = $holidayCollectionFactory;
    }

    public function getEnabledHolidays(){
        $currentTimestamp = time();
        $res = [];

        $holidayCollection = $this->holidayCollectionFactory->create()
        ->addFieldToFilter('status',['eq' => 1]);

        foreach($holidayCollection as $holiday)
        {
            $holidayStart = strtotime($holiday->getStart());
            $holidayEnd = strtotime($holiday->getEnd());
            if($currentTimestamp >= $holidayStart && $currentTimestamp <= $holidayEnd)
            {
                $res[] = $holiday;
            }
        }

        return $res;
    }
}
