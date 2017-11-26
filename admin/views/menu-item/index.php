<?php

use dench\sortable\grid\SortableColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\admin\models\MenuItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu'), 'url' => ['menu/index']];
if (!empty($searchModel->parent)) {
    $this->title = $searchModel->parent->label;
    $this->params['breadcrumbs'][] = ['label' => $searchModel->parent->menu->name, 'url' => ['menu-item/index', 'MenuItemSearch[menu_id]' => $searchModel->parent->menu->id]];
} else {
    $this->title = $searchModel->menu->name;
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create menu item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return [
                'data-position' => $model->position,
            ];
        },
        'columns' => [
            [
                'class' => SortableColumn::className(),
            ],
            [
                'attribute' => 'label',
                'content' => function($data) {
                    return Html::a($data->label, ['index', 'MenuItemSearch[parent_id]' => $data->id]);
                }
            ],
            'link',
            [
                'attribute' => 'enabled',
                'filter' => [
                    Yii::t('app', 'Disabled'),
                    Yii::t('app', 'Enabled'),
                ],
                'content' => function($model, $key, $index, $column){
                    if ($model->enabled) {
                        $class = 'glyphicon glyphicon-ok';
                    } else {
                        $class = '';
                    }
                    return Html::tag('i', '', ['class' => $class]);
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
        'options' => [
            'data' => [
                'sortable' => 1,
                'sortable-url' => Url::to(['sorting']),
            ]
        ],
    ]); ?>
</div>
