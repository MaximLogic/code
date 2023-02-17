<?php
declare(strict_types=1);

namespace Perspective\HelloWorld\Controller\Index;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;

class Testredirect implements ActionInterface{
    /***
    @var \Magento\Framework\Controller\Result\RedirectFactory
    */
    protected $redirectFactory;
    public function __construct(RedirectFactory $redirectFactory)
    {
        $this->redirectFactory = $redirectFactory;
    }
    public function execute()
    {
        return $this->redirectFactory->create()
        ->setUrl('/helloworld/index/testjson');
    }
}