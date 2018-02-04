<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:52
 *
 * @var $model dench\products\models\Product
 */

use dench\image\helpers\ImageHelper;

?>
<div class="product-photo mb-3">
    <div class="photo">
        <?php if ($model->image) { ?>
            <a href="<?= ImageHelper::thumb($model->image->id, 'big') ?>" data-size="<?= Yii::$app->params['image']['size']['big']['width'] ?>x<?= Yii::$app->params['image']['size']['big']['height'] ?>">
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
?>
<?php if (count($images) > 1) : ?>
    <div class="row mx-0">
        <?php foreach ($images as $image) : ?>
            <div class="col-lg-4 col-md-6 px-1">
                <a class="<?php if ($model->image->id == $image->id) echo " active"; ?>" href="<?= ImageHelper::thumb($image->id, 'big') ?>" data-size="<?= $image->width ?>x<?= $image->height ?>">
                    <img class="img-thumbnail" src="<?= ImageHelper::thumb($image->id, 'micro') ?>" alt="<?= $model->image->alt ? $model->image->alt : $model->name ?>" title="<?= $model->title ?>">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>