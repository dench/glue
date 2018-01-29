<?php

use app\models\Order;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\admin\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'buyer.name',
            'buyer.phone',
            'amount',
            'created_at:datetime',
            [
                'attribute' => 'status',
                'filter' => Order::statusList(),
                'content' => function($model, $key, $index, $column){
                    $statusList = Order::statusList();
                    $class = 'default';
                    if ($model->status == Order::STATUS_NEW) {
                        $class = 'danger';
                    } else if ($model->status == Order::STATUS_OLD) {
                        $class = 'default';
                    }
                    return '<span class="badge badge-' . $class . '">' . $statusList[$model->status] . '</span>';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
