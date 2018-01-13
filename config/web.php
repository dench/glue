<?php

/** @var array $params */

$config = [
    'id' => 'app',
    'defaultRoute' => 'site/index',
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
            'class' => 'dench\language\LangRequest'
        ],
        'urlManager' => [
            'class' => 'dench\language\LangUrlManager',
            'defaultLanguage' => 'ru',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<controller:cart|podbor|info>' => '<controller>/index',
                '<action:(how|contacts|questions|reviews)>' => 'site/<action>',
                'image/<size:[0-9a-z\-]+>/<name>.<extension:[a-z]+>' => 'image/default/index',
                'file/<name>.<extension:[a-z]+>' => 'image/default/file',
                'products' => 'category/index',
                'products/<slug:[0-9a-z\-]+>' => 'category/view',
                'product/<slug:[0-9a-z\-]+>' => 'product/index',
                'info/<slug:[0-9a-z\-]+>' => 'info/view',
                'sitemap.xml' => 'sitemap/index',
            ],
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => $params['recaptchaSiteKey'],
            'secret' => $params['recaptchaSecretKey'],
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