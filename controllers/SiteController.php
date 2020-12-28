<?php

namespace app\controllers;

use app\models\CallbackForm;
use app\models\Question;
use app\models\QuestionForm;
use app\models\Review;
use app\models\ReviewForm;
use dench\block\traits\BlockTrait;
use dench\page\models\Page;
use dench\products\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\ContactForm;
use yii\web\Response;

class SiteController extends Controller
{
    use BlockTrait;

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

        $categories = !Yii::$app->cache->exists('_categories-' . Yii::$app->language) ? Category::getMain() : [];

        return $this->render('index', [
            'page' => $page,
            'categories' => $categories,
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

        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['toEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->redirect(Url::current(['#' => 'feedback']));
        }
        return $this->render('contacts', [
            'page' => $page,
            'model' => $model,
        ]);
    }

    /**
     * Displays page.
     *
     * @return string
     */
    public function actionPage($slug)
    {
        $page = Page::viewPage($slug);

        return $this->render('page', [
            'page' => $page,
        ]);
    }

    /**
     * Displays how page.
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
     * Displays questions page.
     *
     * @return string
     */
    public function actionQuestions()
    {
        $page = Page::viewPage(5);

        $model = new QuestionForm();

        if ($model->load(Yii::$app->request->post()) && $model->send()) {
            Yii::$app->session->setFlash('questionSubmitted');
            return $this->redirect(['', '#' => 'card-form']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Question::find()->where(['status' => Question::STATUS_PUBLISHED]),
            'sort' => [
                'defaultOrder' => [
                    'position' => SORT_DESC
                ],
            ],
        ]);

        return $this->render('questions', [
            'page' => $page,
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionReviews()
    {
        $page = Page::viewPage(8);

        $model = new ReviewForm();

        if ($model->load(Yii::$app->request->post()) && $model->send()) {
            Yii::$app->session->setFlash('reviewSubmitted');
            return $this->redirect(['', '#' => 'card-form']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Review::find()
                ->where(['status' => Review::STATUS_PUBLISHED])
                ->andWhere(['product_id' => null]),
            'sort' => [
                'defaultOrder' => [
                    'position' => SORT_DESC
                ],
            ],
        ]);

        return $this->render('reviews', [
            'page' => $page,
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCallback()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new CallbackForm();

        if ($model->load(Yii::$app->request->post()) && $model->send(Yii::$app->params['toEmail'])) {
            return [
                'title' => Yii::t('app', 'Callback'),
                'body' => '<div class="alert alert-success">' . Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.') . '</div>',
            ];
        }

        return [
            'title' => Yii::t('app', 'Callback'),
            'body' => $this->renderAjax('callback', [
                'model' => $model,
            ]),
        ];
    }
}
