<?php

namespace Cognixia\CategoryAttributes\Model\Entity\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;


class Ingredients extends AbstractSource
{
    public function getAllOptions()
    {
        return [
            [
                'label' => 'Tata Namak',
                'value' => 'salt'
            ],
            [
                'label' => 'Teekha',
                'value' => 'chillies'
            ],
            [
                'label' => 'Meetha',
                'value' => 'sugar'
            ]
        ];
    }
}
