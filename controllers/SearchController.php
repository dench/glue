<?php

namespace app\controllers;

use dench\page\models\Page;
use dench\products\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class SearchController extends Controller
{
    public function actionIndex($query)
    {
        $page = Page::viewPage('search');

        if (empty($query)) {
            $query = Product::find()->where(['id' => 0]);
        } else {
            $exp = explode(' ', $query);

            $query = Product::find()->joinWith(['translations']);

            foreach ($exp as $e) {
                $query->orWhere(['like', 'name', $e]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'position' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('index', [
            'page' => $page,
            'dataProvider' => $dataProvider,
        ]);
    }

}
