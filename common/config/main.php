<?php

return [
    'name'=>'Абитуриент',
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                '*'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation'=>true,
                ]
            ]

        ],
    ],
];
