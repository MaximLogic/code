<?php
namespace Perspective\TutorialEntity\Block;

use Magento\Catalog\Api\Data\ProductInterface;

class EntityRepository extends \Magento\Framework\View\Element\Template
{
    /**
    * @var \Magento\Catalog\Api\ProductRepositoryInterface
    */
    private $_productRepository;

    /**
    * @var \Magento\Customer\Api\CustomerRepositoryInterface
    */
    private $_customerRepository;

    /**
    * @var \Magento\Framework\Api\SearchCriteriaBuilder
    */
    private $_searchCriteriaBuilder;

    /**
    * @var \Magento\Framework\Api\FilterBuilder
    */
    private $_filterBuilder;

    /**
    * @var Magento\Framework\Api\Search\FilterGroupBuilder
    */
    private $_filterGroupBuilder;

    /**
    * @var \Magento\Framework\Api\SortOrderBuilder
    */
    private $_sortOrderBuilder;

    /**
    * @param \Magento\Framework\View\Element\Template\Context $context
    * @param array $data
    */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder,
        array $data = []
    ) 
    {
        $this->_productRepository = $productRepository;
        $this->_customerRepository = $customerRepository;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_sortOrderBuilder = $sortOrderBuilder;
        $this->_filterBuilder = $filterBuilder;
        $this->_filterGroupBuilder = $filterGroupBuilder;
        parent::__construct($context, $data);
    }

    public function getProductById($productId)
    {
        if (is_null($productId)){
            return null;
        }
        $productModel = $this->_productRepository->getById($productId);
        return $productModel;
    }

    public function getCheapProducts($price)
    {
        if (is_null($price)){
            return null;
        }
        $this->_searchCriteriaBuilder->addFilter(ProductInterface::PRICE, $price, 'lt');
        $searchCriteria = $this->_searchCriteriaBuilder->create();
        $productCollection = $this->_productRepository->getList($searchCriteria);
        return $productCollection->getItems();
    }

    public function getAllProductsSorted()
    {
        $sortOrder = $this->_sortOrderBuilder->create();
        $sortOrder->setField("name")->setDirection("ASC");

        $searchCriteria = $this->_searchCriteriaBuilder->create();
        $searchCriteria->setPageSize(10);
        $searchCriteria->setSortOrders([$sortOrder]);

        $productCollection = $this->_productRepository->getList($searchCriteria);
        return $productCollection->getItems();
    }

    public function getProductsCreatedAfterDate($date)
    {
        $filterDate[] = $this->_filterBuilder
        ->setField("created_at")
        ->setValue($date)
        ->setConditionType("gt")
        ->create();
        
        $this->_searchCriteriaBuilder->addFilters($filterDate);
        $searchCriteria = $this->_searchCriteriaBuilder->create();
        $searchCriteria->setPageSize(10);

        $productCollection = $this->_productRepository->getList($searchCriteria);
        return $productCollection->getItems();
    }
    
    public function getProductsByCategoryIdCreatedAfterDateSorted($categoryId, $date)
    {
        $filterCategory = $this->_filterBuilder
        ->setField("category_ids")
        ->setValue($categoryId)
        ->setConditionType('eq')
        ->create();

        $filterDate = $this->_filterBuilder
        ->setField("created_at")
        ->setValue($date)
        ->setConditionType("gt")
        ->create();

        $filterGroup1 = $this->_filterGroupBuilder
        ->addFilter($filterCategory)
        ->create();

        $filterGroup2 = $this->_filterGroupBuilder
        ->addFilter($filterDate)
        ->create();

        $searchCriteria = $this->_searchCriteriaBuilder
        ->setFilterGroups([$filterGroup1, $filterGroup2])
        ->create();

        $sortOrder = $this->_sortOrderBuilder->create();
        $sortOrder->setField("name")->setDirection("ASC");

        $searchCriteria->setPageSize(10);
        $searchCriteria->setSortOrders([$sortOrder]);

        $productCollection = $this->_productRepository->getList($searchCriteria);
        return $productCollection->getItems();
    }

    public function getCustomersByGender($gender)
    {
        $filterGender[] = $this->_filterBuilder
        ->setField("gender")
        ->setValue($gender)
        ->setConditionType('eq')
        ->create();

        $this->_searchCriteriaBuilder->addFilters($filterGender);
        $searchCriteria = $this->_searchCriteriaBuilder->create();

        $customerCollection = $this->_customerRepository->getList($searchCriteria);
        return $customerCollection->getItems();
    }

    public function getCustomersByMonthOfBirth($month)
    {
        $filterBirth[] = $this->_filterBuilder
        ->setField("dob")
        ->setValue("%-$month-%")
        ->setConditionType('like')
        ->create();

        $this->_searchCriteriaBuilder->addFilters($filterBirth);
        $searchCriteria = $this->_searchCriteriaBuilder->create();

        $customerCollection = $this->_customerRepository->getList($searchCriteria);
        return $customerCollection->getItems();
    }
}
