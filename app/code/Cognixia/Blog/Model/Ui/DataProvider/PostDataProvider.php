<?php

namespace Cognixia\Blog\Model\Ui\DataProvider;

class PostDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        return null;
    }

    public function getData()
    {
        return [];
    }
}
