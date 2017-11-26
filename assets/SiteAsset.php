<?php

namespace app\assets;

use yii\web\AssetBundle;

class SiteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js',
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js',
        'https://use.fontawesome.com/8a273cb794.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
