<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 25.03.17
 * Time: 13:30
 *
 * @var $model dench\products\models\Product
 * @var $link string
 */

use dench\image\helpers\ImageHelper;

$variant = @$model->variants[0];
?>
<div class="row">
    <div class="col-xs-3 col-sm-4 col-md-3">
        <?php if ($model->image) { ?>
            <img class="img-fluid" src="<?= ImageHelper::thumb($model->image->id, 'small') ?>" alt="<?= $model->image->alt ? $model->image->alt : $model->name ?>" title="<?= $model->title ?>">
        <?php } else { ?>
            <img class="img-fluid" src="<?= Yii::$app->params['image']['none'] ?>" alt="">
        <?php } ?>
    </div>
    <div class="col-xs-9 col-sm-8 col-md-9">
        <h6>
            <a href="<?= $link ?>"><?= $model->name ?></a>
        </h6>
        <div>
            <?= $model->description ?>
        </div>
        <div class="row">
            <div class="col-6">
                <?php if ($variant->available > 0): ?>
                    <div class="text-success"><?= Yii::t('app', 'Available') ?></div>
                <?php else: ?>
                    <div class="text-danger"><?= Yii::t('app', 'Not available') ?></div>
                <?php endif; ?>
                <?php if (@$variant->price) : ?>
                    <div class="price">
                        <?= Yii::t('app', 'Price') ?>:
                        <b>
                        <?php if ($model->price_from) : ?>
                            <?= Yii::t('app', 'from') ?>
                        <?php endif; ?>
                        <?= @$variant->currency->before ?>
                        <?= @$variant->price ?>
                        <?= @$variant->currency->after ?>
                        </b>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-6 text-right">
                <a href="#" class="btn btn-primary"><?= Yii::t('app', 'Buy') ?></a>
            </div>
        </div>

    </div>
</div>
