<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */

use dench\image\helpers\ImageHelper;
use powerkernel\photoswipe\Gallery;

$this->params['breadcrumbs'][] = $page->name;
?>
<h1><?= $page->h1 ?></h1>

<?= $page->text ?>

<?php
$items = [];
foreach ($photos as $photo) {
    $items[] = [
        'src' => ImageHelper::thumb($photo->id, 'category'),
        'width' => 340,
        'height' => 260,
        'alt' => 'Title 1',
    ];
}
echo Gallery::widget([
    'selector'=>'.lightbox',
    'images' => $items,
]);
?>