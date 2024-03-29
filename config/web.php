<?php

/** @var array $params */

use dench\cart\components\WayForPay;

$config = [
    'id' => 'app',
    'defaultRoute' => 'site/index',
    'container' => [
        'definitions' => [
            'yii\widgets\LinkPager' => [
                'options' => [
                    'class' => 'pagination my-3 justify-content-center',
                ],
                'linkContainerOptions' => [
                    'class' => 'page-item',
                ],
                'linkOptions' => [
                    'class' => 'page-link',
                ],
            ],
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['admin/default/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
        'request' => [
            'class' => 'app\components\SiteRequest',
        ],
        'urlManager' => [
            'class' => 'app\components\SiteUrlManager',
            //'defaultLanguage' => 'ru',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<controller:cart|podbor|info>' => '<controller>/index',
                'thankyou' => 'cart/index',
                '<action:(how|contacts|questions|reviews)>' => 'site/<action>',
                'image/<size:[0-9a-z\-]+>/<name>.<extension:[a-z]+>' => 'image/default/index',
                'file/<name>.<extension:[a-z]+>' => 'image/default/file',
                'catalog/page-<page:[0-9]+>' => 'category/index',
                'catalog' => 'category/index',
                'catalog/<slug:[0-9a-z\-]+>/page-<page:[0-9]+>' => 'category/pod',
                'catalog/<slug:[0-9a-z\-]+>' => 'category/pod',
                'products/<slug:[0-9a-z\-]+>/page-<page:[0-9]+>' => 'category/view',
                'products/<slug:[0-9a-z\-]+>' => 'category/view',
                'product/<slug:[0-9a-z\-]+>' => 'product/index',
                'info/<slug:[0-9a-z\-]+>' => 'info/view',
                'popcron' => 'cron/finance',
                'sitemap.xml' => 'sitemap/index',
                'sitemap_ua.xml' => 'sitemap/ua',
                'sitemap_ru.xml' => 'sitemap/ru',
                '<slug:[0-9a-z\-]+>.html' => 'site/page',
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => array(
                    'sourcePath' => null,
                    'js' => array(
                        'https://code.jquery.com/jquery-3.2.1.min.js',
                    ),
                ),
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [],
                ],
                'yii\bootstrap\BootstrapThemeAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'wfp' => [
            'class' => WayForPay::class,
            'test' => true,
            'merchantDomainName' => 'domain',
            'account' => 'test_merch_n1',
            'secret' => 'flk3409refn54t54t*FNJRET',
            //'returnUrl',
            'serviceUrl' => '/wfp',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;