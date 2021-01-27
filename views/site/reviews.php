<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */
/* @var $model app\models\ReviewForm */
/* @var $dataProvider app\models\Review[] */

use app\components\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $page->name;
?>

<div class="card mb-4">
    <div class="card-body px-0">
        <div class="h1 text-center"><h1><?= $page->h1 ?></h1></div>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_review_item',
            'layout' => "{items}\n{pager}",
            'options' => [
                'class' => 'review-list',
            ],
            'itemOptions' => [
                'class' => 'media',
            ],
        ]) ?>
    </div>
</div>

<div class="card mb-4" id="card-form">
    <div class="card-body">
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

                    <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::className())->label(false) ?>

                    <div class="form-group text-center">
                        <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary btn-lg']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $page->text ?>