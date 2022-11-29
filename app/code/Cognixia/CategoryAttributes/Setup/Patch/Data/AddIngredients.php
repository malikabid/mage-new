<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Cognixia\CategoryAttributes\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute as CatalogAttribute;

/**
 * Patch is mechanism, that allows to do atomic upgrade data changes
 */
class AddIngredients implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;

    private $categorySetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategorySetupFactory $categorySetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $catalogSetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);

        $catalogSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'ingredients');
        $catalogSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'ingredients', [
            'label' => 'Ingredients',
            'visible_on_frontend' => 1,
            'required' => 0,
            'global' => CatalogAttribute::SCOPE_STORE,
            'source' => \Cognixia\CategoryAttributes\Model\Entity\Attribute\Source\Ingredients::class,
            'input' => 'multiselect',
            'backend' => \Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend::class

        ]);
        $this->moduleDataSetup->endSetup();
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }
}
