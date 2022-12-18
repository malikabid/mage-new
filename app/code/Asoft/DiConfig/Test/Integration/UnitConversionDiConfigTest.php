<?php

namespace Asoft\DiConfig\Test\Integration;

use PHPUnit\Framework\TestCase;
use Magento\TestFramework\ObjectManager;
use Magento\Framework\ObjectManager\ConfigInterface as ObjectManagerConfig;

class UnitConversionDiConfigTest extends TestCase
{

    private $configType = \Asoft\DiConfig\Model\Config\UnitConversion\Virtual::class;

    private $readerType = \Asoft\DiConfig\Model\Config\UnitConversion\Reader\Virtual::class;

    private $schemaLocatorType = \Asoft\DiConfig\Model\Config\UnitConversion\SchemaLocator\Virtual::class;

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

    public function testUnitCoversionConfigDataDiConfig()
    {
        $this->assertVirtualType(\Magento\Framework\Config\Data::class, $this->configType);
        $this->assertDiArgumentSame('asoft_unitmap_config', $this->configType, 'cacheId');
        $this->assertDiArgumentType($this->readerType, $this->configType, 'reader');
    }

    public function testUnitCoversionConfigReaderDiConfig()
    {
        $this->assertVirtualType(\Magento\Framework\Config\Reader\Filesystem::class, $this->readerType);
        $this->assertDiArgumentSame('unit_conversion.xml', $this->readerType, 'fileName');
        $this->assertDiArgumentType($this->schemaLocatorType, $this->readerType, 'schemaLocator');
    }

    public function testUnitCoversionConfigSchemaLocatorDiConfig()
    {
        $this->assertVirtualType(\Magento\Framework\Config\GenericSchemaLocator::class, $this->schemaLocatorType);
        $this->assertDiArgumentSame('Asoft_DiConfig', $this->schemaLocatorType, 'moduleName');
        $this->assertDiArgumentSame('unit_conversion.xsd', $this->schemaLocatorType, 'schema');
    }

    public function testUnitConversionDataCanBeAccessed()
    {
        /** @var \Magento\Framework\Config\DataInterface $unitConversionConfig */
        $unitConversionConfig = ObjectManager::getInstance()->create($this->configType);
        $configData = $unitConversionConfig->get(null);
        $this->assertIsArray($configData);
        $this->assertNotEmpty($configData);
    }
}
