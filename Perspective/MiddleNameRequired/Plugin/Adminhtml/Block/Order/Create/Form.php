<?php
namespace Perspective\MiddleNameRequired\Plugin\Adminhtml\Block\Order\Create;

class Form
{
    protected $request;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->request = $request;
    }

    public function aroundToHtml(
        \Magento\Sales\Block\Adminhtml\Order\Create\Form $subject,
        callable $proceed
    ) {
        $html = $proceed();

        $shippingMethod = $this->request->getParam('order')['shipping_method'] ?? null;

        if ($shippingMethod === 'freeshipping_freeshipping') {
            $html = str_replace('name="order[customer][middlename]"', 'name="order[customer][middlename]" required', $html);
        }

        return $html;
    }
}