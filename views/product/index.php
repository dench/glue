<?php

/* @var $this yii\web\View */
/* @var $model dench\products\models\Product */
/* @var $similar dench\products\models\Product[] */
/* @var $viewed boolean */


echo $this->render('_breadcrumbs', [
    'model' => $model,
]);

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

<div class="card my-3">
    <a class="card-header bg-dark text-white" id="headingDoc" data-toggle="collapse" href="#collapseDoc" aria-expanded="true" aria-controls="collapseText">
        <?= Yii::t('app', 'Documents') ?>
    </a>
    <div id="collapseDoc" class="collapse show" aria-labelledby="headingDoc" data-parent="#accordion">
        <div class="card-body">
            ...
        </div>
    </div>
</div>

<div class="card my-3">
    <a class="card-header bg-dark text-white" id="headingTips" data-toggle="collapse" href="#collapseTips" aria-expanded="true" aria-controls="collapseText">
        <?= Yii::t('app', 'Tips for use') ?>
    </a>
    <div id="collapseTips" class="collapse show" aria-labelledby="headingTips" data-parent="#accordion">
        <div class="card-body">
            <?= $model->text_tips ?>
        </div>
    </div>
</div>

<?= $this->render('_options', [
    'options' => $model->options,
]) ?>