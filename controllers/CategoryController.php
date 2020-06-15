<?php

namespace app\controllers;

use app\components\Category;
use app\components\Page;
use dench\products\models\Feature;
use dench\products\models\ProductFilter;
use Yii;
use yii\web\Controller;

class CategoryController extends Controller
{
    public function actionIndex()
    {
        $page = Page::viewPage(2);

        $categories = !Yii::$app->cache->exists('_categories-' . Yii::$app->language) ? Category::getMain() : [];

        return $this->render('index', [
            'page' => $page,
            'categories' => $categories,
        ]);
    }

    public function actionPod($slug)
    {
        $page = Category::viewPage($slug);

        /** @var $category Category */
        $category = Category::find()->where(['slug' => $slug])->one();

        $categories = $category->categories;

        return $this->render('pod', [
            'page' => $page,
            'categories' => $categories,
        ]);
    }

    public function actionView($slug)
    {
        $page = Category::viewPage($slug);

        $this->view->params['category_ids'] = [$page->id];

        $searchModel = new ProductFilter(['category_id' => $page->id, 'enabled' => true]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $features = Feature::getFilterList(true, [$searchModel->category_id]);

        return $this->render('view', [
            'page' => $page,
            'categories' => $page->categories,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'features' => $features,
        ]);
    }

}
