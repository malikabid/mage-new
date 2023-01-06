<?php

namespace Cognixia\DisableRegistration\Test\Integration;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Module\ModuleList;
use Magento\TestFramework\ObjectManager;
use PHPUnit\Framework\TestCase;

class DisableRegistrationModuleConfigTest extends TestCase
{
    private $modulename = "Cognixia_DisableRegistration";

    public function testTheModuleIsRegistered()
    {
        $registrar = new ComponentRegistrar();
        $this->assertArrayHasKey($this->modulename, $registrar->getPaths(ComponentRegistrar::MODULE));
    }

    public function testTheModuleIsConfiguredAndEnabled()
    {
        /** @var ObjectManager $objectManager */
        $objectManager = ObjectManager::getInstance();

        /** @var ModuleList $moduleList */
        $moduleList = $objectManager->create(ModuleList::class);

        $isModuleListed = $moduleList->has($this->modulename);
        $this->assertTrue($isModuleListed);
    }

    public function testTheModuleIsConfiguredAndEnabledInRealEnvironment()
    {
        /** @var ObjectManager $objectManager */
        $objectManager = ObjectManager::getInstance();

        $dirList = $objectManager->create(\Magento\Framework\App\Filesystem\DirectoryList::class, ['root' => BP]);

        $configReader = $objectManager->create(\Magento\Framework\App\DeploymentConfig\Reader::class, ['dirList' => $dirList]);
        $deploymentConfig = $objectManager->create(\Magento\Framework\App\DeploymentConfig::class, ['reader' => $configReader]);


        /** @var ModuleList $moduleList */
        $moduleList = $objectManager->create(ModuleList::class, ['config' => $deploymentConfig]);

        $isModuleListed = $moduleList->has($this->modulename);
        $this->assertTrue($isModuleListed);
    }
}
