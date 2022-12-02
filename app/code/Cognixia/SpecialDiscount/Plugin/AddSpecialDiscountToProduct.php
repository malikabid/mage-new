<?php

namespace Cognixia\SpecialDiscount\Plugin;

class AddSpecialDiscountToProduct
{

    public function afterGet(
        \Magento\Catalog\Api\ProductRepositoryInterface $subject,
        \Magento\Catalog\Api\Data\ProductInterface $entity
    ) {

        $extensionAttributes = $entity->getExtensionAttributes();
        $extensionAttributes->setSpecialDiscount(10);
        $entity->setExtensionAttributes($extensionAttributes);

        return $entity;
    }


    public function afterGetList(
        \Magento\Catalog\Api\ProductRepositoryInterface $subject,
        \Magento\Catalog\Api\Data\ProductSearchResultsInterface $searchCriteria
    ): \Magento\Catalog\Api\Data\ProductSearchResultsInterface {
        $products = [];
        foreach ($searchCriteria->getItems() as $entity) {
            $extensionAttributes = $entity->getExtensionAttributes();
            $extensionAttributes->setSpecialDiscount(10);
            $entity->setExtensionAttributes($extensionAttributes);

            $products[] = $entity;
        }

        $searchCriteria->setItems($products);
        return $searchCriteria;
    }
}
