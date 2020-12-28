<?php

use app\models\Question;
use dench\products\models\Product;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Review */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->dropDownList(Product::getList(null), ['prompt' => '-']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'answer')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'customConfig' => '/js/ckeditor.js',
            'language' => Yii::$app->language,
            'allowedContent' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rating')->dropDownList([0,1,2,3,4,5]) ?>

    <?= $form->field($model, 'created_at')->textInput()->label('Создан (unixtime)') ?>

    <?= $form->field($model, 'status')->dropDownList(Question::statusList()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
