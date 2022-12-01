<?php

namespace Cognixia\Blog\Block\Adminhtml\Post\Edit;

use Cognixia\Blog\Model\Post;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var Post
     */
    protected $post;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context,
        Post $post
    ) {
        $this->context = $context;
        $this->post = $post;
    }


    /*
    * Return CMS page ID
    *
    * @return int|null
    */
    public function getPostId()
    {
        try {
            return $this->post->load(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }


    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
