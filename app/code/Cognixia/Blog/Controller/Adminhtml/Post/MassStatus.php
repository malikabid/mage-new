<?php

namespace Cognixia\Blog\Controller\Adminhtml\Post;

use Exception;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Cognixia\Blog\Model\ResourceModel\Post\CollectionFactory;

class MassStatus extends \Magento\Backend\App\Action
{

    protected $filter;

    protected $collectionFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $status = (int) $this->getRequest()->getParam('status');

        $postUpdated = 0;
        foreach ($collection as $post) {
            try {
                $post->setEnabled($status)->save();
                $postUpdated++;
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    __('Something went wrong while updating status for %1.', $post->getName())
                );
            }
        }

        if ($postUpdated) {
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', $postUpdated));
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
