<?php

use yii\widgets\ListView;

/** @var $this yii\web\View */
/** @var $page dench\page\models\Page */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $page->name;
?>
<h1><?= $page->h1 ?></h1>

<div class="news">
<?php
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'layout' => "<div class=\"row cards\">{items}</div>\n<div class=\"clear-pager text-center\">{pager}</div>",
    'emptyTextOptions' => [
        'class' => 'alert alert-danger',
    ],
]);
?>
</div>

<?= $page->text ?>