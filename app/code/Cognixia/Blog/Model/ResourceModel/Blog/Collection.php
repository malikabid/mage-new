<?php

namespace Cognixia\Blog\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init('Cognixia\Blog\Model\Blog','Cognixia\Blog\Model\ResourceModel\Blog');
    }
}
