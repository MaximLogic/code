<?php
namespace Perspective\ProductWishList\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Index implements ArgumentInterface
{
    /**
     * @var \Magento\Wishlist\Model\WishlistFactory
     */
    private $wishlistFactory;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    private $customerCollectionFactory;

    public function __construct(
        \Magento\Wishlist\Model\WishlistFactory $wishlistFactory,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory
    )
    {
        $this->wishlistFactory = $wishlistFactory;
        $this->customerCollectionFactory = $customerCollectionFactory;
    }

    private function getCustomerCollection()
    {
        return $this->customerCollectionFactory->create()->addAttributeToSelect('*');
    }

    public function getWishListCount($productId)
    {
        $customerCollection = $this->getCustomerCollection();
        $count = 0;
        foreach($customerCollection as $value)
        {
            $wishlist = $this->wishlistFactory->create()->loadByCustomerId($value->getData('entity_id'))->getItemCollection();
            foreach($wishlist as $item)
            {
                if($item->getData('product_id') == $productId)
                {
                    $count += 1;
                }
            }
        }

        return $count;
    }
}
