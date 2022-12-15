<?php

namespace Cognixia\DisableRegistration\Controller\Index;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\Redirect as RedirectResult;
use Magento\Framework\Controller\Result\RedirectFactory as RedirectResultFactory;
use Cognixia\DisableRegistration\Model\Exception\RequiredArgumentMissingException;

class Index extends \Magento\Framework\App\Action\Action
{
    /** @var PageFactory */
    protected $_pageFactory;

    /** @var RedirectResultFactory */
    private $redirectResultFactory;

    /**
     * Constructor function
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     * @param \stdClass $useCase
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \stdClass $useCase
    ) {
        $this->_pageFactory = $pageFactory;
        $this->useCase = $useCase;
        $this->redirectResultFactory = $context->getResultRedirectFactory();

        return parent::__construct($context);
    }

    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return !$this->isPostRequest() ?
            $this->getMethodNotAllowedResult() :
            $this->processRequestAndRedirect();
    }

    /** @return \Magento\Framework\Controller\ResultInterface | RedirectResult */
    private function processRequestAndRedirect()
    {
        try {
            $this->useCase->doSomething($this->getRequest()->getParams());
            return $this->getRedirectToHomePageResult();
        } catch (RequiredArgumentMissingException $exception) {
            return $this->getBadRequestResult();
        }
    }

    /**  @return RedirectResult  */
    private function getRedirectToHomePageResult()
    {
        $redirect = $this->redirectResultFactory->create();
        $redirect->setPath('/');

        return $redirect;
    }

    /** @return boolean */
    private function isPostRequest(): bool
    {
        return $this->getRequest()->getMethod() === 'POST';
    }

    /** @return \Magento\Framework\Controller\ResultInterface */
    private function getBadRequestResult()
    {
        $result = $this->_pageFactory->create();
        $result->setHttpResponseCode(400);
        return $result;
    }

    /** @return \Magento\Framework\Controller\ResultInterface */
    private function getMethodNotAllowedResult()
    {
        $result = $this->_pageFactory->create();
        $result->setHttpResponseCode(405);
        return $result;
    }
}
