<?php
namespace Perspective\GuessCityIp\Cron;

class SincNpCities
{
    /**
     * @var \Perspective\GuessCityIp\Model\ResourceModel\City\CollectionFactory
     */
    private $cityCollectionFactory;

    /**
     * @var \Perspective\GuessCityIp\Model\ResourceModel\City
     */
    private $cityResource;

    /**
     * @var \Perspective\GuessCityIp\Model\CityFactory
     */
    private $cityModelFactory;

    /**
     * @var \Perspective\GuessCityIp\Block\Index
     */
    private $blockHelper;

    public function __construct(
        \Perspective\GuessCityIp\Model\ResourceModel\City\CollectionFactory $cityCollectionFactory,
        \Perspective\GuessCityIp\Model\ResourceModel\City $cityResource,
        \Perspective\GuessCityIp\Model\CityFactory $cityModelFactory,
        \Perspective\GuessCityIp\Block\Index $blockHelper
    )
    {
        $this->cityCollectionFactory = $cityCollectionFactory;
        $this->cityResource = $cityResource;
        $this->cityModelFactory = $cityModelFactory;
        $this->blockHelper = $blockHelper;
        
    }

    public function execute()
    {
        $cityCollection = $this->cityCollectionFactory->create();
        foreach($cityCollection as $city)
        {
            $cityModel = $this->cityModelFactory->create();
            $this->cityResource->load($cityModel, $city->getEntityId());
            $this->cityResource->delete($cityModel);
        }
        $npCities = $this->blockHelper->getNpCities();
        $this->blockHelper->saveCities($npCities);
    }
}
