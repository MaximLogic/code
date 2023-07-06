<?php
namespace Perspective\SellerConsultation\Model;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Perspective\SellerConsultation\Model\ResourceModel\Question\CollectionFactory $questionCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $questionCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $extension) {
            $this->loadedData[$extension->getQuestionId()] = $extension->getData();
        }
        return $this->loadedData;
    }
}
