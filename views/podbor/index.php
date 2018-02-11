<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */

use app\widgets\Gallery;
use dench\image\helpers\ImageHelper;

$this->params['breadcrumbs'][] = $page->name;
?>
<h1><?= $page->h1 ?></h1>

<?= $page->text ?>