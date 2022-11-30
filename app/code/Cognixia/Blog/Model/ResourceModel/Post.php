<?php

namespace Cognixia\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    public function _construct()
    {
        $this->_init('blog_post', 'entity_id');
    }
}
