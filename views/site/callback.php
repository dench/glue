<?php
/**
 * @var $this yii\web\View
 * @var $form yii\bootstrap\ActiveForm
 * @var $model app\models\ContactForm
 */

use app\components\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

<?= $form->field($model, 'name')->textInput() ?>

<?= $form->field($model, 'phone') ?>

<?php if (!YII_DEBUG): ?>
    <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::class)->label(false) ?>
<?php endif; ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'callback-button']) ?>
</div>

<?php ActiveForm::end(); ?>

