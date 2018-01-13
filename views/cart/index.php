<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */
/* @var $items dench\products\models\Variant[] */
/* @var $cart array */

$this->params['breadcrumbs'][] = $page->name;
?>
<h1><?= $page->h1 ?></h1>

<?= $page->text ?>

<?= $this->render('_table', [
    'items' => $items,
    'cart' => $cart,
]) ?>

<div class="mt-4">
    <a href="#" class="btn btn-warning pull-right"><?= Yii::t('app', 'Place an order') ?></a>
    <a href="#" class="btn btn-primary"><?= Yii::t('app', 'Continue shopping') ?></a>
</div>