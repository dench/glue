<?php
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\ReviewForm */

use app\components\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha;
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
    'emptyText' => 'Пока ещё никто не оставил отзыв на этот товар. После покупки, обязательно оставьте отзыв.',
]) ?>

<div class="text-center <?= !Yii::$app->session->hasFlash('reviewSubmitted') ? null : 'collapse' ?>">
    <?= Html::button('Оставить отзыв', ['class' => 'btn btn-primary btn-lg', 'onclick' => '$(this).hide().parent().next().slideDown();']) ?>
</div>

<div id="card-form" class="<?= Yii::$app->session->hasFlash('reviewSubmitted') ? null : 'collapse' ?>">
    <div class="h1 text-center">Оставить отзыв</div>
    <?php if (Yii::$app->session->hasFlash('reviewSubmitted')): ?>
        <div class="alert alert-success">
            Отзыв успешно добавлен и будет опубликован на сайте после проверки администратором.
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

                <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::class)->label(false) ?>

                <div class="form-group text-center">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-lg']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
