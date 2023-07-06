<?php
namespace Perspective\SellerConsultation\Ui\Component\Listing\Column;

class QuestionActions extends \Magento\Ui\Component\Listing\Columns\Column
{

    const URL_EDIT_PATH = 'perspective_questions/question/edit';
    const URL_DELETE_PATH = 'perspective_questions/question/delete';
    const URL_RESPOND_PATH = 'perspective_questions/question/respond';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) 
        {
            foreach ($dataSource['data']['items'] as &$item)
            {
                if (isset($item['question_id']))
                {               
                    if($item['status'] != 'Closed')
                    {
                        $item[$this->getData('name')] = [
                            'delete' => [
                                'href' => $this->urlBuilder->getUrl(
                                    static::URL_DELETE_PATH,
                                    [
                                        'question_id' => $item['question_id']
                                    ]
                                ),
                                'label' => __('Delete'),
                            ],
                            'respond' => [
                                'href' => $this->urlBuilder->getUrl(
                                    static::URL_RESPOND_PATH,
                                    [
                                        'question_id' => $item['question_id']
                                    ]
                                ),
                                'label' => __('Respond'),
                            ]
                        ];
                    }
                    else
                    {
                        $item[$this->getData('name')] = [
                            'delete' => [
                                'href' => $this->urlBuilder->getUrl(
                                    static::URL_DELETE_PATH,
                                    [
                                        'question_id' => $item['question_id']
                                    ]
                                ),
                                'label' => __('Delete'),
                            ]
                        ];
                    }
                }
            }
        }

        return $dataSource;
    }
}
