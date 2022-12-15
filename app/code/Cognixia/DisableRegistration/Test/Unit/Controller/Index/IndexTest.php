<?php

namespace Cognixia\DisableRegistration\Test\Unit\Controller\Index;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page as PageResult;
use Cognixia\DisableRegistration\Controller\Index\Index;
use Magento\Framework\App\Action\Context as ActionContext;
use Magento\Framework\HTTP\PhpEnvironment\Request as HttpRequest;
use Magento\Framework\View\Result\PageFactory as PageResultFactory;
use Cognixia\DisableRegistration\Model\Exception\RequiredArgumentMissingException;
use Magento\Framework\Controller\Result\Redirect as RedirectResult;
use Magento\Framework\Controller\Result\RedirectFactory as RedirectResultFactory;

class IndexTest extends TestCase
{

    /** @var Index */
    private $controller;

    /** @var HttpRequest | MockObject */
    private $mockRequest;

    /** @var  PageResult |  MockObject */
    private $mockPageResult;

    /** @var stdClass  | MockObject */
    private $mockUseCase;

    /** @var RedirectRestult | MockObject */
    private $mockRedirectResult;

    protected function setUp(): void
    {
        $this->mockRequest = $this->getMockBuilder(HttpRequest::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockPageResult = $this->getMockBuilder(PageResult::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockUseCase = $this->getMockBuilder(\stdClass::class)
            ->setMockClassName('UseCase')
            ->addMethods(['doSomething'])
            ->getMock();

        $this->mockRedirectResult = $this->getMockBuilder(RedirectResult::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var PageResultFactory |  MockObject */
        $mockPageResultFactory = $this->getMockBuilder(PageResultFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockPageResultFactory->method('create')->willReturn($this->mockPageResult);

        /** @var RedirectResultFactory | MockObject */
        $mockRedirectResultFactory = $this->getMockBuilder(RedirectResultFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockRedirectResultFactory->method('create')->willReturn($this->mockRedirectResult);

        /** @var ActionContext | MockObject */
        $mockContext = $this->getMockBuilder(ActionContext::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockContext->method('getRequest')->willReturn($this->mockRequest);
        $mockContext->method('getResultRedirectFactory')->willReturn($mockRedirectResultFactory);

        $this->controller = new Index($mockContext, $mockPageResultFactory, $this->mockUseCase);
    }

    public function testReturnsResultInstance()
    {
        $this->mockRequest->method('getMethod')->willReturn('POST');
        $this->assertInstanceOf(ResultInterface::class, $this->controller->execute());
    }

    public function testReturns405MethodNotAllowedForNonPostRequest()
    {
        $this->mockRequest->method('getMethod')->willReturn('GET');
        $this->mockPageResult->expects($this->once())->method('setHttpResponseCode')->with(405);
        $this->controller->execute();
    }

    public function testReturns400BadRequestIfRequiredArgumentsAreMissing()
    {
        $incompleteArguments = [];
        $this->mockRequest->method('getMethod')->willReturn('POST');
        $this->mockRequest->method('getParams')->willReturn($incompleteArguments);

        $this->mockUseCase->expects($this->once())
            ->method('doSomething')
            ->with($incompleteArguments)
            ->willThrowException(new RequiredArgumentMissingException('Test exception: required argument missing'));

        $this->mockPageResult->expects($this->once())->method('setHttpResponseCode')->with(400);
        $this->controller->execute();
    }

    public function testRedirectToHomePageIfRequestWasProcessed()
    {
        $this->mockRequest->method('getMethod')->willReturn('POST');
        $this->mockRequest->method('getParams')->willReturn(['foo_id' => 123]);

        $this->mockRedirectResult->expects($this->once())->method('setPath');
        $this->assertSame($this->mockRedirectResult, $this->controller->execute());
    }
}
