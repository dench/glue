<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */

use app\models\Podbor;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = $page->name;

?>
<h1><?= $page->h1 ?></h1>

<?= $page->text ?>

<?= Html::dropDownList('first', null, Podbor::getParentList(null))?>
