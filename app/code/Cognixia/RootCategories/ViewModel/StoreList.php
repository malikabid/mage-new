<?php

namespace Cognixia\RootCategories\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManager;
use Magento\Catalog\Model\CategoryFactory;


class StoreList implements ArgumentInterface
{

    protected $storeManager;

    protected $categoryFactory;

    public function __construct(
        StoreManager $storeManager,
        CategoryFactory $categoryFactory
    ) {
        $this->storeManager = $storeManager;
        $this->categoryFactory = $categoryFactory;
    }

    public function getRootCategories()
    {
        $storeList = $this->storeManager->getStores();
        $storeRootCategory = $this->categoryFactory->create();


        $stores = [];
        foreach ($storeList as $store) {
            $rootCategoryName = $storeRootCategory->load($store->getRootCategoryId())->getName();
            $stores[] = [
                'store_name' => $store->getName(),
                'root_category'  => $rootCategoryName,

            ];
        }

        $stores = array_map(function ($item) {
            $string = 'STORE ' . $item['store_name'] . '<br/>';
            $string .= 'ROOT CATEGORY ' . $item['root_category'] . '<br/>';
            return $string;
        }, $stores);

        return implode('', $stores);
    }
}
