<?php

/* @var $this yii\web\View */
/* @var $model dench\products\models\Product */
/* @var $similar dench\products\models\Product[] */
/* @var $viewed boolean */

echo $this->render('_breadcrumbs', [
    'model' => $model,
]);

?>
<h1 class="mb-3"><?= $model->h1 ?></h1>
<div class="row">
    <div class="col-md-5">
        <?= $this->render('_photo', [
            'model' => $model,
        ]) ?>
    </div>
    <div class="col-md-7">
        <?= $this->render('_feature_simple', [
            'model' => $model,
        ]) ?>
    </div>
</div>

<?= $this->render('_text', [
    'name' => $model->name,
    'text' => $model->text,
]) ?>

<?= $this->render('_complects', [
    'complects' => $model->complects,
]) ?>

<?= $this->render('_options', [
    'options' => $model->options,
]) ?>

<?= $this->render('_similar', [
    'viewed' => $viewed,
    'similar' => $similar,
]) ?>