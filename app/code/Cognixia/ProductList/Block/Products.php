<?php

namespace Cognixia\ProductList\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;

class Products extends \Magento\Framework\View\Element\Template
{

    protected $productRepository;

    protected $searchCriteriaBuilder;

    protected $filterBuilder;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
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
}
