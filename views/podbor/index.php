<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */

use app\widgets\Gallery;
use dench\image\helpers\ImageHelper;

$this->params['breadcrumbs'][] = $page->name;
?>
<h1><?= $page->h1 ?></h1>

<?= $page->text ?>

<?php
/*
$items = [];
foreach ($photos as $photo) {
    $items[] = [
        'image' => ImageHelper::thumb($photo->id, 'page'),
        'thumb' => ImageHelper::thumb($photo->id, 'cover'),
        'width' => 600,
        'height' => 450,
        'title' => 'Title 1',
    ];
}
echo Gallery::widget([
    'items' => $items,
]);
*/
?>