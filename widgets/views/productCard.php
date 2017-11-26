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
    <div class="col-sm-3 col-md-3 text-center">
        <a href="<?= $link ?>" rel="nofollow">
        <?php if ($model->image) { ?>
            <img class="img-fluid" src="<?= ImageHelper::thumb($model->image->id, 'small') ?>" alt="<?= $model->image->alt ? $model->image->alt : $model->name ?>" title="<?= $model->title ?>">
        <?php } else { ?>
            <img class="img-fluid" src="<?= Yii::$app->params['image']['none'] ?>" alt="">
        <?php } ?>
        </a>
    </div>
    <div class="col-sm-9 col-md-9">
        <h3>
            <a href="<?= $link ?>"><?= $model->name ?></a>
        </h3>
        <div>
            <?= $model->description ?>
        </div>
        <div class="row mt-2">
            <div class="col-sm-6">
                <?php if ($variant->available > 0): ?>
                    <div class="text-success my-2"><i class="fa fa-check"></i> <?= Yii::t('app', 'In stock') ?></div>
                <?php else: ?>
                    <div class="text-danger my-2"><i class="fa fa-times"></i> <?= Yii::t('app', 'Not available') ?></div>
                <?php endif; ?>
                <?php if (@$variant->price) : ?>
                    <div>
                        <?= Yii::t('app', 'Price') ?>:
                        <b>
                        <?php if ($model->price_from) : ?>
                            <?= Yii::t('app', 'from') ?>
                        <?php endif; ?>
                        <span class="h3">
                            <?= @$variant->currency->before ?>
                            <?= @$variant->price ?>
                            <?= @$variant->currency->after ?>
                        </span>
                        </b>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-sm-6 text-sm-right pt-2">
                <a href="#" class="btn btn-primary btn-lg"><?= Yii::t('app', 'Order Now') ?></a>
            </div>
        </div>

    </div>
</div>
