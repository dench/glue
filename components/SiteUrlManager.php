<?php

namespace app\components;

use dench\language\LangUrlManager;
use Yii;

class SiteUrlManager extends LangUrlManager
{
    public function parseRequest($request)
    {
        if (strpos($request->url, 'index.php') || strpos($request->url, 'index.html')) {
            Yii::$app->response->redirect('/', 301);
        }

        return parent::parseRequest($request);
    }
}