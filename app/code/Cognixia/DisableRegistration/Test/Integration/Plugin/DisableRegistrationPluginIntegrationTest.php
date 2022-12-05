<?php

namespace Cognixia\DisableRegistration\Test\Integration\Plugin;

use Cognixia\DisableRegistration\Plugin\DisableRegistration;
use PHPUnit\Framework\TestCase;
use Magento\Customer\Model\Registration;
use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\Interception\PluginList;

class DisableRegistrationPluginIntegrationTest extends TestCase
{
    public function testDisableRegistrionPluginExist()
    {
        $objectManager = ObjectManager::getInstance();

        $pluginList = $objectManager->create(PluginList::class);

        $pluginInfo = $pluginList->get(Registration::class, []);
        $this->assertSame(
            DisableRegistration::class,
            $pluginInfo['cognixia_diable_registraion']['instance']
        );
    }
}
