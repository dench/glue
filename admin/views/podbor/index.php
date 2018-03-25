<?php

use app\models\Podbor;
use dench\sortable\grid\SortableColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\admin\models\PodborSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$parent_id = Yii::$app->request->get('PodborSearch')['parent_id'];

/** @var Podbor $parent */
$parent = Podbor::find()->where(['id' => $parent_id])->one();

if (isset($parent)) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Selection'), 'url' => ['index']];
    if (isset($parent->parent)) {
        $this->params['breadcrumbs'][] = ['label' => $parent->parent->name, 'url' => ['index', 'PodborSearch[parent_id]' => $parent->parent->id]];
    }
    $this->title = $parent->name;
} else {
    $this->title = Yii::t('app', 'Selection');
}
$this->params['breadcrumbs'][] = $this->title;

if (!Yii::$app->request->get('all') && $dataProvider->totalCount > $dataProvider->count) {
    $showAll = Html::a(Yii::t('app', 'Show all'), Url::current(['all' => 1]));
} else {
    $showAll = '';
}
?>
<div class="podbor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create {0}', Yii::t('app', 'Category')), ['create', 'parent_id' => $parent_id], ['class' => 'btn btn-success']) ?>
        <?= isset($parent->id) ? Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $parent->id], ['class' => 'btn btn-primary']) : '' ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return [
                'data-position' => $model->position,
            ];
        },
        'layout' => "{summary}\n{$showAll}\n{items}\n{pager}",
        'columns' => [
            [
                'class' => SortableColumn::className(),
            ],
            [
                'attribute' => 'name',
                'content' => function($model, $key, $index, $column){
                    return Html::a($model->name, ['podbor/index', 'PodborSearch[parent_id]' => $model->id]);
                },
            ],
            'parent_id',
            'position',
            'enabled',
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
