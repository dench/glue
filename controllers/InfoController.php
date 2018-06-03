<?php

namespace app\controllers;

use dench\page\models\Page;
use yii\web\NotFoundHttpException;

class InfoController extends \yii\web\Controller
{
    private $_id = 6;

    public function actionIndex()
    {
        $page = Page::viewPage($this->_id);

        return $this->render('index', [
            'page' => $page,
            'childs' => $page->childs,
        ]);
    }

    public function actionView($slug)
    {
        $page = Page::viewPage($slug);

        if (!$page->enabled) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', [
            'page' => $page,
            'childs' => $page->childs,
        ]);
    }
}
