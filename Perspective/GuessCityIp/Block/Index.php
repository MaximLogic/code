<?php
namespace Perspective\GuessCityIp\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Perspective\GuessCityIp\Model\ResourceModel\City\CollectionFactory
     */
    private $cityCollectionFactory;

    /**
     * @var \Magento\Framework\HTTP\Client\Curl
     */
    private $curl;

    /**
     * @var \Perspective\GuessCityIp\Model\CityFactory
     */
    private $cityFactory;

    /**
     * @var \Perspective\GuessCityIp\Model\ResourceModel\City
     */
    private $cityResourceModel;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Perspective\GuessCityIp\Model\ResourceModel\City\CollectionFactory $cityCollectionFactory,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Perspective\GuessCityIp\Model\CityFactory $cityFactory,
        \Perspective\GuessCityIp\Model\ResourceModel\City $cityResourceModel,
        array $data = []
    ) {
        $this->cityCollectionFactory = $cityCollectionFactory;
        $this->curl = $curl;
        $this->cityFactory = $cityFactory;
        $this->cityResourceModel = $cityResourceModel;
        parent::__construct($context, $data);
    }

    public function getCityCollection()
    {
        return $this->cityCollectionFactory->create();
    }

    public function getNpCities()
    {
        $url = "https://api.novaposhta.ua/v2.0/json/";
        $params = 
        [
            "apiKey" => "c4affaaf682cb040e7c466077bdad8ec",
            "modelName" => "Address",
            "calledMethod" => "getCities"
        ];
        $this->curl->post($url, json_encode($params));
        $result = json_decode($this->curl->getBody(), true);
        return $result;
    }

    public function saveCities($cities)
    {
        foreach($cities["data"] as $city)
        {
            if($city["DescriptionRu"] != "")
            {
                $cityModel = $this->cityFactory->create();
                $cityModel->setCity($city["Description"])
                          ->setCityRu($city["DescriptionRu"])
                          ->setRegion($city["AreaDescription"]);
                $this->cityResourceModel->save($cityModel);
            }
        }
    }
}