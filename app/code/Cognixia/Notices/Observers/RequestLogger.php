<?php

namespace Cognixia\Notices\Observers;

use Magento\Framework\Event\Observer;

class RequestLogger implements \Magento\Framework\Event\ObserverInterface
{


    protected $logger;

    protected $request;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->logger = $logger;
        $this->request = $request;
    }

    public function execute(Observer $observer)
    {
        $this->logger->critical(
            "We are Logging Request" .  $this->request->getPathInfo()
        );
    }
}
