<?php

namespace Cognixia\DisableRegistration\Test\Unit\Plugin;

use PHPUnit\Framework\TestCase;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Cognixia\DisableRegistration\Plugin\DisableRegistration;
use Magento\Customer\Model\Registration as CustomerRegistrationModel;

class DisableRegistrationPluginTest extends TestCase
{
    /**
     * @var DisableRegistration
     */
    private $plugin;

    /**
     * @var CustomerRegistrationModel | \PHPUnit\Framework\MockObject\MockObject
     */
    private $mockCustomerRegistrationModel;

    /**
     *
     * @var ScopeConfigInterface | \PHPUnit\Framework\MockObject\MockObject
     */
    private $scopeConfigInterface;


    protected function setUp(): void
    {
        $this->mockCustomerRegistrationModel = $this->getMockBuilder(CustomerRegistrationModel::class)->getMock();
        $this->scopeConfigInterface = $this->createMock(ScopeConfigInterface::class);

        $this->plugin =  new DisableRegistration(
            $this->scopeConfigInterface
        );
    }

    // public function testAfterIsAllowedMethodCanBeCalled()
    // {
    //     $result = $this->plugin->afterIsAllowed(
    //         $this->mockCustomerRegistrationModel,
    //         // $this->createMock(CustomerRegistrationModel::class),
    //         true
    //     );
    //     $this->assertFalse($result);
    // }

    public function testAfterIsAllowed()
    {
        $this->scopeConfigInterface->expects($this->once())->method('isSetFlag')
            ->with(DisableRegistration::XML_PATH_DISABLE_CUSTOMER_REGISTRATION, ScopeInterface::SCOPE_STORE)
            ->will($this->returnValue(true));

        $this->assertFalse((bool)$this->plugin->afterIsAllowed(
            $this->mockCustomerRegistrationModel,
            true
        ));
    }
}
