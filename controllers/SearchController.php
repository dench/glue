<?php

namespace app\controllers;

use dench\page\models\Page;
use dench\products\models\Category;
use dench\products\models\Product;
use dench\products\models\Variant;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;

class SearchController extends Controller
{
    public function actionIndex($query)
    {
        $page = Page::viewPage('search');

        if (empty($query)) {
            $query = Product::find()->where(['id' => 0]);
        } else {
            $query = str_replace('loxeal','', $query);

            $exp = explode(' ', trim($query));

            $query = Product::find()->joinWith(['translations']);

            foreach ($exp as $e) {
                $query->orWhere(['like', 'name', $e]);
                $query->orWhere(['like', 'description', $e]);
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

    public function actionList($q = null)
    {
        $q = trim($q);

        $data = Product::find()->select(['id', 'name', 'slug'])->joinWith(['translations'])->where(['enabled' => 1])->andFilterWhere(['like', 'name', $q])->asArray()->limit(100)->all();

        $out = [];

        foreach ($data as $d) {
            $out[] = [
                'value' => $d['name'],
                'link' => Url::to(['product/index', 'slug' => $d['slug']]),
            ];
        }

        $data = Category::find()->select(['id', 'name', 'slug', 'parent_id'])->joinWith(['translations'])->where(['enabled' => 1])->andFilterWhere(['like', 'name', $q])->asArray()->all();

        foreach ($data as $d) {
            if ($d['parent_id']) {
                $out[] = [
                    'value' => $d['name'],
                    'link' => Url::to(['category/pod', 'slug' => $d['slug']]),
                ];
            } else {
                $out[] = [
                    'value' => $d['name'],
                    'link' => Url::to(['category/view', 'slug' => $d['slug']]),
                ];
            }
        }

        return Json::encode($out);
    }

    public function actionProductList()
    {
        $data = [];

        $products = Product::find()->where(['enabled' => true])->all();
        foreach ($products as $product) {
            $variants = Variant::find()->where(['enabled' => true])->andWhere(['product_id' => $product->id])->all();
            foreach ($variants as $variant) {
                $data[] = [
                    'id' => $variant->id,
                    'value' => $product->name . ", " . $variant->name,
                    'price' => $variant->price,
                ];
            }
        }

        return Json::encode($data);
    }

}
