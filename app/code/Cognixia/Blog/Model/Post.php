<?php

namespace Cognixia\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use Cognixia\Blog\Model\ResourceModel\Post as PostResouce;

class Post extends AbstractModel
{
    public function _construct()
    {
        $this->_init(PostResouce::class);
    }
}
