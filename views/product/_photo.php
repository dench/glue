<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:52
 *
 * @var $model dench\products\models\Product
 */

use app\widgets\Gallery;
use dench\image\helpers\ImageHelper;

?>
<div class="product-photo mb-3">
    <div class="photo">
        <?php if ($model->image) { ?>
            <a class="gallery-item" href="<?= ImageHelper::thumb($model->image->id, 'big') ?>" data-size="<?= Yii::$app->params['image']['size']['big']['width'] ?>x<?= Yii::$app->params['image']['size']['big']['height'] ?>">
                <img class="img-fluid" src="<?= ImageHelper::thumb($model->image->id, 'normal') ?>" alt="<?= $model->image->alt ? $model->image->alt : $model->name ?>" title="<?= $model->title ?>">
            </a>
        <?php } else { ?>
            <div class="thumbnail">
                <img class="img-fluid" src="/img/photo-default.png" alt="photo-default">
            </div>
        <?php } ?>
    </div>
</div>
<?php
$images = [];
foreach ($model->variants as $variant) {
    foreach ($variant->images as $image) {
        $images[] = $image;
    }
}
if (count($images) > 1) {
    $items = [];
    foreach ($images as $photo) {
        $items[] = [
            'image' => ImageHelper::thumb($photo->id, 'big'),
            'thumb' => ImageHelper::thumb($photo->id, 'micro'),
            'width' => Yii::$app->params['image']['size']['big']['width'],
            'height' => Yii::$app->params['image']['size']['big']['height'],
            'title' => $photo->alt,
        ];
    }
    echo Gallery::widget([
        'items' => $items,
        'options' => [
            'class' => 'gallery row mx-0',
        ],
        'itemOptions' => [
            'class' => 'img-thumbnail',
        ],
        'linkOptions' => [
            'class' => 'gallery-item col-lg-4 col-md-6 px-1',
        ],
    ]);
}
?>