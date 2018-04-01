<?php

namespace app\controllers;

use app\models\PodborForm;
use dench\page\models\Page;
use Yii;

class PodborController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $page = Page::viewPage(3);

        $model = new PodborForm();

        if ($model->load(Yii::$app->request->post()) && $model->send()) {

        }

        return $this->render('index', [
            'page' => $page,
            'model' => $model,
        ]);
    }

}
