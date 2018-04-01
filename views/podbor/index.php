<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */

use app\components\ActiveForm;
use app\models\Podbor;
use yii\bootstrap\Html;

$this->params['breadcrumbs'][] = $page->name;

?>
<h1><?= $page->h1 ?></h1>

<?= $page->text ?>
<!--
< ?php $form = ActiveForm::begin(); ?>

< ?php foreach ($model->step as $step => $parent_id): ?>
    < ?= $form->field($model, 'step[' . $step . ']')->dropDownList($model->list[$step], ['prompt' => '-'])->label($model->label[$step]) ?>
< ?php endforeach; ?>

< ?= Html::submitButton('Send') ?>

< ?= $form->field($model, 'step[0]')->dropDownList(Podbor::getParentList(null), ['prompt' => '-'])->label('?') ?>

< ?php if (!empty($model->step_1)): ?>
    < ?= $form->field($model, 'step_2')->dropDownList($model->step_1_list, ['prompt' => '-'])->label($model->step_1_title) ?>
< ?php endif; ?>

< ?php if (!empty($model->step_2)): ?>
    < ?= $form->field($model, 'step_3')->dropDownList($model->step_2_list, ['prompt' => '-'])->label($model->step_2_title) ?>
< ?php endif; ?>

< ?php if (!empty($model->step_3)): ?>
    < ?= $form->field($model, 'step_4')->dropDownList($model->step_3_list, ['prompt' => '-'])->label($model->step_3_title) ?>
< ?php endif; ?>

< ?php if (!empty($model->step_4)): ?>
    < ?= $form->field($model, 'step_5')->dropDownList($model->step_4_list, ['prompt' => '-'])->label($model->step_4_title) ?>
< ?php endif; ?>

< ?php ActiveForm::end(); ?>
-->