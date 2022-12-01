<?php

namespace Cognixia\ProductList\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;

class Products extends \Magento\Framework\View\Element\Template
{

    protected $productRepository;

    protected $searchCriteriaBuilder;

    protected $filterBuilder;

    protected $sortOrderBuilder;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        SortOrderBuilder $sortOrderBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    public function getName()
    {
        return "Fetching product list...";
    }

    public function getProductCount()
    {
        return count($this->getProductsFromRepository());
    }

    public function getProductList()
    {
        return $this->getProductsFromRepository();
    }

    protected function getProductsFromRepository()
    {
        $criteria = $this->searchCriteriaBuilder->create();
        $this->setProductTypeFilter();
        // $this->setProductNameFilter();

        $this->setProductOrder();
        $this->setPaging();

        $produts = $this->productRepository->getList($criteria);
        return $produts->getItems();
    }

    private function setProductTypeFilter()
    {
        $configProductFilter = $this->filterBuilder
            ->setField('type_id')
            ->setValue('configurable')
            ->setConditionType('eq')
            ->create();

        $this->searchCriteriaBuilder->addFilter($configProductFilter);
    }

    private function setProductNameFilter()
    {
        $productNameFilter = $this->filterBuilder
            ->setField('name')
            ->setValue('M%')
            ->setConditionType('like')
            ->create();
        $this->searchCriteriaBuilder->addFilter($productNameFilter);
    }

    private function setProductOrder()
    {
        $this->searchCriteriaBuilder->addSortOrder('name', SortOrder::SORT_ASC);
    }

    private function setPaging()
    {
        $this->searchCriteriaBuilder->setPageSize(10);
        $this->searchCriteriaBuilder->setCurrentPage(1);
    }
}
