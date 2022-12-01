<?php

namespace Cognixia\Blog\Controller\Adminhtml\Post;

use Cognixia\Blog\Model\Post;
use Exception;

class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Cognixia_Blog::delete';

    const PAGE_TITLE = 'Delete Post';

    /**
     * @var Post
     */
    protected $postModel;

    /**
     * cosntructor function
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param Post $postModel
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Post $postModel
    ) {
        $this->postModel = $postModel;
        return parent::__construct($context);
    }


    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $this->postModel->load($id);
                $this->postModel->delete();

                $this->messageManager->addSuccessMessage(__('The post has been deleted.'));
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        } else {
            $this->messageManager->addErrorMessage(__('Post was not found'));
        }

        $resultRedirect->setPath('*/*/');
        return $resultRedirect;
    }

    /**
     * Is the user allowed to view the page.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
