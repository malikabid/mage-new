<?php

namespace Cognixia\DisableRegistration\Test\Integration;

use PHPUnit\Framework\TestCase;
use Magento\TestFramework\Request;
use Magento\Framework\App\Router\Base as BaseRouter;
use Magento\TestFramework\ObjectManager;
use Magento\Framework\App\Route\ConfigInterface as RouteConfig;

class RouterConfigTest extends TestCase
{
    private $modulename = "Cognixia_DisableRegistration";

    /** @var ObjectManager $objectManager */
    private $objectManager;

    protected function setUp(): void
    {

        $this->objectManager = ObjectManager::getInstance();
    }

    /**
     * @magentoAppArea frontend
     */
    public function testTheModuleRegistersRouter()
    {
        /** @var RouteConfig $routeConfig */
        $routeConfig = $this->objectManager->create(RouteConfig::class);
        $this->assertContains($this->modulename, $routeConfig->getModulesByFrontName('dcr'));
    }

    /**
     * @magentoAppArea frontend
     */
    public function testDcrIndexIndexCanBeFound()
    {
        $request = $this->objectManager->create(Request::class);
        $request->setModuleName('dcr');
        $request->setControllerName('index');
        $request->setActionName('index');

        /** @var BaseRouter $baseRouter */
        $baseRouter = $this->objectManager->create(BaseRouter::class);
        $expectedAction = \Cognixia\DisableRegistration\Controller\Index\Index::class;

        $this->assertInstanceOf($expectedAction, $baseRouter->match($request));
    }
}
