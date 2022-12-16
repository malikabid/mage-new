<?php

namespace Cognixia\DisableRegistration\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\ForwardFactory as ForwardResultFactory;

class Page extends \Magento\Framework\App\Action\Action
{
    /** @var PageFactory */
    protected $_pageFactory;


    /** @var ForwardResultFactory */
    private $forwardFactory;

    /**
     * construct function
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param ForwardResultFactory $forwardFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        ForwardResultFactory $forwardFactory
    ) {
        $this->_pageFactory = $pageFactory;
        $this->forwardFactory = $forwardFactory;
        return parent::__construct($context);
    }

    /**
     * View page action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        return $this->isGetRequest() ?
            $this->handleGetRequest() :
            $this->handleNonGetRequest();
    }

    /**
     * @return ResultInterface
     */
    private function handleNonGetRequest()
    {
        return $this->forwardFactory->create()->forward('noroute');
    }

    /**
     * @return ResultInterface
     */
    private function handleGetRequest()
    {
        return $this->_pageFactory->create();
    }

    /**
     * @return boolean
     */
    private function isGetRequest(): bool
    {
        return $this->getRequest()->getMethod() === 'GET';
    }

    /**
     * getRequest function
     * to avoid getMethod function not avaiable error in IDE
     * this function is optional
     * 
     * @return \Magento\Framework\App\Request\Http
     */
    public function getRequest()
    {
        return parent::getRequest();
    }
}
