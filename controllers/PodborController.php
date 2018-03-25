<?php

namespace app\controllers;

use dench\image\models\Image;
use dench\page\models\Page;

class PodborController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $page = Page::viewPage(3);

        return $this->render('index', [
            'page' => $page,
        ]);
    }

}
