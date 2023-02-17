<?php
declare(strict_types=1);

namespace Perspective\HelloWorld\Controller\Index;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\ForwardFactory;

class Testforward implements ActionInterface{
    /***
    @var \Magento\Framework\Controller\Result\ForwardFactory
    */
    protected $forwardFactory;
    /**
    * Forward constructor.
    *
    * @param \Magento\Framework\Controller\Result\ForwardFactory
    $forwardFactory
    */
    public function __construct(ForwardFactory $forwardFactory)
    {
        $this->forwardFactory = $forwardFactory;
    }
    public function execute()
    {
        return $this->forwardFactory->create()
        ->forward('testraw');
    }
}