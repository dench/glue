<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Menu');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create menu'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'name',
                'content' => function($data) {
                    return Html::a($data->name, ['menu-item/index', 'MenuItemSearch[menu_id]' => $data->id]);
                }
            ],
            [
                'attribute' => 'enabled',
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
    ]); ?>
</div>
