<?php
namespace Perspective\SellerConsultation\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Email extends AbstractHelper
{   
    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    private $inlineTranslation;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    private $productModel;

    private $logger;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Catalog\Model\Product $productModel,
    )
    {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->productModel = $productModel;
        $this->logger = $context->getLogger();
    }

    public function sendEmail($name, $subject, $questionId, $email, $question, $answer, $productId)
    {
        try
        {
            $this->inlineTranslation->suspend();

            $product = $this->productModel->load($productId);
            $sender = [
                'name' => 'Test',
                'email' => 'test@test.com',
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('email_templ')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'name'  => $name,
                    'subject' => $subject,
                    'questionId'  => $questionId,
                    'question'  => $question,
                    'answer'  => $answer,
                    'product' => $product->getName(),
                    'answerDate'  => date("Y-m-d")
                ])
                ->setFrom($sender)
                ->addTo($email)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        }
        catch(\Exception $e)
        {
            $this->logger->critical($e->getMessage());
        }
    }
}
