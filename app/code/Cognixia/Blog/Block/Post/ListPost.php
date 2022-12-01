<?php

namespace Cognixia\Blog\Block\Post;

use Cognixia\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ListPost extends \Magento\Framework\View\Element\Template
{
    private $blogCollectionFactory;
    private $scopeConfig;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        PostCollectionFactory $postCollectionFactory,
        ScopeConfigInterface $scopeConfigInterface,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->blogCollectionFactory = $postCollectionFactory;
        $this->scopeConfig = $scopeConfigInterface;
    }

    public function getPostList()
    {
        return $this->getPostCollection()->getItems();
    }

    private function getPostCollection()
    {
        return $this->blogCollectionFactory->create()
            ->addFieldToFilter('enabled', 1);
    }

    public function getConfigurations()
    {
        $dispalyTextValue = $this->scopeConfig->getValue('blog_general/general/display_text', 'website');
        return $dispalyTextValue;
    }
}
