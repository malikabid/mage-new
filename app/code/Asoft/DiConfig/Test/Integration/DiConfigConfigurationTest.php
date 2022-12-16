<?php

namespace Asoft\DiConfig\Test\Integration;

use PHPUnit\Framework\TestCase;
use Magento\TestFramework\ObjectManager;
use Magento\Framework\ObjectManager\ConfigInterface as ObjectManagerConfig;

class DiConfigConfigurationTest extends TestCase
{

    /**
     *
     * @return ObjectManagerConfig
     */
    private function getDiConfig()
    {
        return ObjectManager::getInstance()->get(ObjectManagerConfig::class);
    }

    /**
     *
     * @param string $expectedType
     * @param string $type
     */
    private function assertVirtualType($expectedType, $type)
    {
        $this->assertSame($expectedType, $this->getDiConfig()->getInstanceType($type));
    }

    /**
     *
     * @param mixed $expected
     * @param string $type
     * @param string $argumentName
     * 
     */
    private function assertDiArgumentSame($expected, $type, $argumentName)
    {
        $arguments = $this->getDiConfig()->getArguments($type);
        if (!isset($arguments[$argumentName])) {
            $this->fail(sprintf('No arguments "%s" configured for "%s"', $argumentName, $type));
        }
        $this->assertSame($expected, $arguments[$argumentName]);
    }

    /**
     *
     * @param string $expectedType
     * @param string $type
     * @param string $argumentName
     * 
     */
    private function assertDiArgumentType($expectedType, $type, $argumentName)
    {
        $arguments = $this->getDiConfig()->getArguments($type);
        if (!isset($arguments[$argumentName])) {
            $this->fail(sprintf('No arguments "%s" configured for "%s"', $argumentName, $type));
        }

        if (!isset($arguments[$argumentName]['instance'])) {
            $this->fail(sprintf('Arguments "%s" for "%s" is not xsi:type="object"', $argumentName, $type));
        }

        $this->assertSame($expectedType, $arguments[$argumentName]['instance']);
    }

    public function testConfigDataVirtualType()
    {
        $type = \Asoft\DiConfig\Model\Config\Data\Virtual::class;
        $this->assertVirtualType(\Magento\Framework\Config\Data::class, $type);
        $this->assertDiArgumentSame('asoft_unitmap_config', $type, 'cacheId');
        $this->assertDiArgumentType(\Asoft\DiConfig\Model\Config\Data\Reader::class, $type, 'reader');
    }
}
