<?php

namespace Cognixia\DisableRegistration\Test\Integration\Controller\Index;

use Magento\TestFramework\TestCase\AbstractController;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class PageTest extends AbstractController
{
    public function testCanHandleGetRequest()
    {
        $this->getRequest()->setMethod('GET');
        $this->dispatch('dcr/index/page');
        $this->assertSame(200, $this->getResponse()->getHttpResponseCode());
        $this->assertStringContainsString('<body', $this->getResponse()->getBody());
    }

    public function testCannotHandleNonGetRequests()
    {
        $this->getRequest()->setMethod('POST');
        $this->dispatch('dcr/index/page');
        $this->assertSame(404, $this->getResponse()->getHttpResponseCode());
        $this->assert404NotFound();
    }
}
