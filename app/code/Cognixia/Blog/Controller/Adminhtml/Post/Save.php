<?php

namespace Cognixia\Blog\Controller\Adminhtml\Post;

class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Cognixia_Blog::save';

    const PAGE_TITLE = 'Save Blog';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        $data = $this->getRequest()->getParams();

        if ($data) {
            $model = $this->_objectManager->create(\Cognixia\Blog\Model\Post::class);
            if (!$data['entity_id']) {
                unset($data['entity_id']);
            }
            $model->setData($data);
            $model->save();
        }

        $id = $model->getId();

        if ($id) {
            $this->messageManager->addSuccessMessage(__('The post was saved successfully'));
        } else {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving the post'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();


        $resultRedirect->setPath('*/edit', ['id' => $id, '_current' => true]);

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
