<?php

namespace app\controllers;

use app\components\Category;
use app\components\Page;
use dench\products\models\Feature;
use dench\products\models\Product;
use dench\products\models\ProductFilter;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    public function actionIndex()
    {
        if (!$page = Page::viewPage(2)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $categories = !Yii::$app->cache->exists('_categories-' . Yii::$app->language) ? Category::getMain() : [];

        $query = Product::find();
        $query->joinWith(['categories']);
        $query->andWhere(['product.enabled' => true]);
        $query->andWhere(['category.enabled' => true]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'position' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 12,
            ],
        ]);

        return $this->render('index', [
            'page' => $page,
            'categories' => $categories,
            'dataProvider' => $dataProvider,
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

        if (!empty(Yii::$app->params['templateTitleCategory'])) {
            $page->title = str_replace('{0}', $page->h1, Yii::$app->params['templateTitleCategory']);

            if (empty($model->description)) {
                $page->description = str_replace('{0}', $page->h1, Yii::$app->params['templateDescriptionCategory']);
            }

            Yii::$app->view->title = $page->title;
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $page->description
            ]);
        }

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
