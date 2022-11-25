<?php

namespace Cognixia\Blog\Block;

use Cognixia\Blog\Model\ResourceModel\Blog\CollectionFactory;

class Recent extends \Magento\Framework\View\Element\Template
{
    protected $blogCollection;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        CollectionFactory $blogCollection,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->blogCollection =  $blogCollection;
    }
    private function getBlogs()
    {
        $blogs = $this->blogCollection->create();
        return $blogs->getData();
    }
    public function getRecentBlogs()
    {
        return $this->getBlogs();
    }
}
