<?php

/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */

$this->params['breadcrumbs'][] = $page->name;
?>

<h1 class="mb-3"><?= $page->h1 ?></h1>

<?= $page->short ?>

<?= $page->text ?>