<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */
/* @var $model app\models\QuestionForm */
/* @var $dataProvider app\models\Question[] */

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
            'itemView' => '_question_item',
            'layout' => "{items}\n{pager}",
            'options' => [
                'class' => 'question-list',
            ],
            'itemOptions' => [
                'class' => 'media',
            ],
        ]) ?>
    </div>
</div>

<div class="card mb-4" id="card-form">
    <div class="card-body">
        <div class="h1 text-center">Задать вопрос</div>
        <?php if (Yii::$app->session->hasFlash('questionSubmitted')): ?>
            <div class="alert alert-success">
                Сообщение успешно отправлено и скоро Вы получите ответ.
            </div>
        <?php else: ?>
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'text')->textarea(['rows' => 5]) ?>

                    <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::className())->label(false) ?>

                    <div class="form-group text-center">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-lg']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $page->text ?>