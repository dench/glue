<?php

/* @var $this yii\web\View */
/* @var $page \dench\page\models\Page */

$this->params['breadcrumbs'][] = $page->name;
?>

<h1 class="title"><?= $page->h1 ?></h1>
<div class="page-text">
    <?= $page->text ?>
</div>