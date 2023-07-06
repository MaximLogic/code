<?php
namespace Perspective\SellerConsultation\Ui\Component\Listing\Column;

class Question extends \Magento\Ui\Component\Listing\Columns\Column {

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ){
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource) 
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) 
            {
                if(strlen($item['question_text']) > 70)
                {
                    $item['question_text'] = substr($item['question_text'],0,70);
                    $item['question_text'] = $item['question_text'] . '...';
                }
                
            }
        }
        return $dataSource;
    }
}
