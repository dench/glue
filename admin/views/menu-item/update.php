<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MenuItem */

$this->title = $model->label;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu'), 'url' => ['menu/index']];
$this->params['breadcrumbs'][] = ['label' => $model->menu->name, 'url' => ['menu-item/index', 'MenuItemSearch[menu_id]' => $model->menu->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
