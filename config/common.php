<?php

use yii\mutex\MysqlMutex;
use yii\queue\db\Queue;

$params = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'version' => '0.1',
    'name' => 'Site',
    'basePath' => dirname(__DIR__),
    'language' => 'ru',
    'sourceLanguage' => 'en',
    'bootstrap' => ['log'],
    'aliases' => [
        '@admin' => '@app/admin',
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\admin\Module',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'modules' => [
                'page' => [
                    'class' => 'dench\page\Module',
                ],
                'block' => [
                    'class' => 'dench\block\Module',
                ],
                'products' => [
                    'class' => 'dench\products\Module',
                ],
                'cart' => [
                    'class' => 'dench\cart\Module',
                ],
            ],
        ],
        'image' => [
            'class' => 'dench\image\Module',
        ],
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'mailer2' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'log' => [
            'class' => 'yii\log\Dispatcher',
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'fs' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'page' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath' => '@vendor/dench/yii2-page/messages',
                ],
                'cart' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@vendor/dench/yii2-cart/messages',
                ],
            ],
        ],
        'queue' => [
            'class' => Queue::class,
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'default',
            'mutex' => MysqlMutex::class,
        ],
    ],
    'params' => $params,
];