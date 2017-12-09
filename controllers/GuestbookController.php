<?php

namespace app\controllers;

use dench\page\models\Page;

class GuestbookController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $page = Page::viewPage(8);

        return $this->render('index', [
            'page' => $page,
        ]);
    }

}
