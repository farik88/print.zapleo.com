<?php
return [
    'language' => 'ru',
    'name'=>'Mycase',
    'sourceLanguage' => 'ru',
    'timeZone' => 'Europe/Kiev', //опционально, играет роль для каждого конкретного проекта
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
      'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
      'datecontrol' => [
            'class' => '\kartik\datecontrol\Module',
        ],
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
        ]
    ],
    'components' => [
        'user' => [
            'class' => 'common\components\services\User',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'showScriptName' => false,
            'enablePrettyUrl' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'confs' => [
            'class' => 'common\components\services\Settings'
        ], 
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ],
                'front*' => [
                    'class' => 'common\components\services\DbMsgSource',
                ],
                'back*' => [
                    'class' => 'common\components\services\DbMsgSource',
                ],
            ]
        ]
    ],
];
