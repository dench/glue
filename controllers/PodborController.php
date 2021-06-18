<?php

namespace app\controllers;

use app\models\Podbor;
use app\models\PodborForm;
use dench\page\models\Page;
use dench\products\models\Product;
use Yii;
use yii\bootstrap\Alert;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;

class PodborController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $page = Page::viewPage(3);

        $model = new PodborForm();

        return $this->render('index', [
            'page' => $page,
            'model' => $model,
        ]);
    }

    public function actionChildList()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $parent_id = $parents[0];
                $temp = Podbor::getParentList($parent_id);
                foreach ($temp as $k => $v) {
                    $out[] = [
                        'id' => $k,
                        'name' => $v,
                    ];
                }

                $podbor = Podbor::findOneEnabled($parent_id);

                echo Json::encode([
                    'output' => $out,
                    'selected' => '',
                    'label' => $podbor->title,
                    'help' => $podbor->text,
                ]);
                return;
            }
        }
        echo Json::encode([
            'output' => '',
            'selected' => '',
        ]);
    }

    public function actionResult()
    {
        if (!Yii::$app->request->isAjax) return '';

        $id = Yii::$app->request->post('id');

        if (!$podbor = Podbor::findOneEnabled($id)) {
            return Alert::widget([
                'body' => Yii::t('yii', 'No results found.'),
                'options' => [
                    'class' => 'alert-danger',
                ],
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $podbor->getProducts(),
            'sort'=> [
                'defaultOrder' => [
                    'position' => SORT_ASC,
                ],
            ],
        ]);

        if ($dataProvider->totalCount == 1) {
            $model = current($dataProvider->models);

            $view = 'index';

            if ($model->view) {
                $view = $model->view;
            }

            return $this->renderAjax('../product/' . $view, [
                'model' => $model,
                'viewed' => null,
                'similar' => null,
            ]);
        }

        return $this->renderAjax('_result_list', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
