<?php

use app\models\Menu;
use app\models\MenuItem;
use dench\language\models\Language;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MenuItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php foreach (Language::suffixList() as $suffix => $name) : ?>
        <?= $form->field($model, 'label' . $suffix)->textInput(['maxlength' => true]) ?>
    <?php endforeach; ?>

    <?= $form->field($model, 'menu_id')->dropDownList(Menu::dropDownList()) ?>

    <?= $form->field($model, 'parent_id')->dropDownList(MenuItem::dropDownList(), ['prompt' => '']) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enabled')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
