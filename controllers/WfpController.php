<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class WfpController extends Controller
{
    public function actionIndex()
    {
        echo Yii::$app->wfp->serviceUrl();
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}