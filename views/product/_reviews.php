<?php
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\ReviewForm */

use app\components\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha2;
use yii\bootstrap\Html;
use yii\widgets\ListView;

?>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '../site/_review_item',
    'layout' => "{items}\n{pager}",
    'options' => [
        'class' => 'review-list mb-4',
    ],
    'itemOptions' => [
        'class' => 'media',
    ],
    'emptyText' => Yii::t('app', 'No one has left a review for this product yet. Please leave a review after purchase.'),
]) ?>

<div class="text-center <?= !Yii::$app->session->hasFlash('reviewSubmitted') ? null : 'collapse' ?>">
    <?= Html::button(Yii::t('app', 'Leave a review'), ['class' => 'btn btn-primary btn-lg', 'onclick' => '$(this).hide().parent().next().slideDown();']) ?>
</div>

<div id="card-form" class="<?= Yii::$app->session->hasFlash('reviewSubmitted') ? null : 'collapse' ?>">
    <div class="h1 text-center"><?= Yii::t('app', 'Leave a review') ?></div>
    <?php if (Yii::$app->session->hasFlash('reviewSubmitted')): ?>
        <div class="alert alert-success">
            <?= Yii::t('app', 'The review has been successfully added and will be published on the site after verification by the administrator.') ?>
        </div>
    <?php else: ?>
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'rating')->dropDownList([
                    5 => 5,
                    4 => 4,
                    3 => 3,
                    2 => 2,
                    1 => 1,
                ]) ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'text')->textarea(['rows' => 5]) ?>

                <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha2::class)->label(false) ?>

                <div class="form-group text-center">
                    <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary btn-lg']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
