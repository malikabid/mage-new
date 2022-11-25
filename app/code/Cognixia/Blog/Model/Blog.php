<?php

namespace Cognixia\Blog\Model;

use Magento\Framework\Model\AbstractModel;

class Blog extends AbstractModel
{
    public function _construct()
    {
        $this->_init('Cognixia\Blog\Model\ResourceModel\Blog');
    }
}
