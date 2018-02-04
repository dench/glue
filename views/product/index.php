<?php

/* @var $this yii\web\View */

use app\widgets\OrderScheme;

/* @var $model dench\products\models\Product */
/* @var $similar dench\products\models\Product[] */
/* @var $viewed boolean */


echo $this->render('_breadcrumbs', [
    'model' => $model,
]);

$js = <<<JS
$('.card').on('hidden.bs.collapse', function () {
  $(this).find('.fa').removeClass('fa-minus-square').addClass('fa-plus-square');
}).on('shown.bs.collapse', function () {
  $(this).find('.fa').removeClass('fa-plus-square').addClass('fa-minus-square');
})
JS;

$this->registerJs($js);

?>
<h1><?= $model->h1 ?></h1>
<div class="row">
    <div class="col-sm-5">
        <?= $this->render('_photo', [
            'model' => $model,
        ]) ?>
    </div>
    <div class="col-sm-7">
        <?= $this->render('_price', [
            'model' => $model,
        ]) ?>
    </div>
</div>

<?= $this->render('_text', [
    'name' => $model->name,
    'text' => $model->text,
]) ?>

<?= $this->render('_feature', [
    'model' => $model,
]) ?>

<?= $this->render('_files', [
    'model' => $model,
]) ?>

<?php if ($model->text_tips) : ?>
<div class="card my-3">
    <a class="card-header bg-dark text-white" id="headingTips" data-toggle="collapse" href="#collapseTips" aria-expanded="true" aria-controls="collapseText">
        <i class="fa fa-minus-square"></i><?= $model->getAttributeLabel('text_tips') ?>
    </a>
    <div id="collapseTips" class="collapse show" aria-labelledby="headingTips" data-parent="#accordion">
        <div class="card-body">
            <?= $model->text_tips ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if ($model->text_process) : ?>
    <div class="card my-3">
        <a class="card-header bg-dark text-white" id="headingProcess" data-toggle="collapse" href="#collapseProcess" aria-expanded="true" aria-controls="collapseText">
            <i class="fa fa-minus-square"></i><?= $model->getAttributeLabel('text_process') ?>
        </a>
        <div id="collapseProcess" class="collapse show" aria-labelledby="headingProcess" data-parent="#accordion">
            <div class="card-body">
                <?= $model->text_process ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->text_use) : ?>
    <div class="card my-3">
        <a class="card-header bg-dark text-white" id="headingUse" data-toggle="collapse" href="#collapseUse" aria-expanded="true" aria-controls="collapseText">
            <i class="fa fa-minus-square"></i><?= $model->getAttributeLabel('text_use') ?>
        </a>
        <div id="collapseUse" class="collapse show" aria-labelledby="headingUse" data-parent="#accordion">
            <div class="card-body">
                <?= $model->text_use ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->text_storage) : ?>
    <div class="card my-3">
        <a class="card-header bg-dark text-white" id="headingStorage" data-toggle="collapse" href="#collapseStorage" aria-expanded="true" aria-controls="collapseText">
            <i class="fa fa-minus-square"></i><?= $model->getAttributeLabel('text_storage') ?>
        </a>
        <div id="collapseStorage" class="collapse show" aria-labelledby="headingStorage" data-parent="#accordion">
            <div class="card-body">
                <?= $model->text_storage ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->render('_options', [
    'options' => $model->options,
]) ?>

<?= OrderScheme::widget() ?>