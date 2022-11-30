<?php

namespace Cognixia\Blog\Model\ResourceModel\Post;

use Cognixia\Blog\Model\Post;
use Cognixia\Blog\Model\ResourceModel\Post as PostResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Post::class, PostResource::class);
    }
}
