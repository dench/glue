<?php

return [
    'id' => 'app-console',
    'bootstrap' => ['queue', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
];
