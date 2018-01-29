<?php

use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <h4><?= $model->buyer->name ?></h4>
    <h4><?= $model->buyer->phone ?></h4>
    <h4><?= $model->buyer->delivery ?></h4>

    <ul class="list-group mt-4">
        <?php
        $total = 0;
        foreach ($model->products as $product) {
            echo '<li class="list-group-item"><span class="badge">' . @$model->cartItemPrice[$product->id] . ' грн</span> <span class="badge">' . @$model->cartItemCount[$product->id] . ' шт</span> ' . @$model->cartItemName[$product->id] . '</li>';
            $total += $model->cartItemCount[$product->id] * $model->cartItemPrice[$product->id];
        }
        ?>
    </ul>

    <h2 class="text-right mb-5"><?= $total ?> грн</h2>

    <?= $form->field($model, 'buyer_id')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(Order::statusList()) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
