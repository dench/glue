<?php

namespace app\controllers;

use app\models\CallbackForm;
use dench\products\models\Category;
use dench\page\models\Page;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $page = Page::viewPage(1);

        return $this->render('index', [
            'page' => $page,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContacts()
    {
        $page = Page::viewPage(7);

        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->redirect(Url::current(['#' => 'feedback']));
        }
        return $this->render('contacts', [
            'page' => $page,
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionHow()
    {
        $page = Page::viewPage(4);

        return $this->render('how', [
            'page' => $page,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionQa()
    {
        $page = Page::viewPage(5);

        return $this->render('qa', [
            'page' => $page,
        ]);
    }

    /**
     * @return string
     */
    public function actionCallback()
    {
        $model = new CallbackForm();

        if ($model->load(Yii::$app->request->post()) && $model->send(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return 'success';
        }
        return $this->renderAjax('callback', [
            'model' => $model,
        ]);
    }
}
