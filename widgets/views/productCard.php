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

use app\widgets\PriceTable;
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
        <div class="h3 my-3">
            <a href="<?= $link ?>"><?= $model->name ?></a>
        </div>
        <div>
            <?= $model->text_short ?>
        </div>
        <?php if ($variant->available > 0): ?>
            <div class="text-success my-2"><i class="fa fa-check"></i> <?= Yii::t('app', 'In stock') ?></div>
        <?php elseif ($variant->available < 0): ?>
            <div class="text-warning my-2"><i class="fa fa-clock-o"></i> <?= Yii::t('app', 'On order') ?></div>
        <?php else: ?>
            <div class="text-danger my-2"><i class="fa fa-times"></i> <?= Yii::t('app', 'Not available') ?></div>
        <?php endif; ?>
        <div class="row mt-2">
            <div class="col-sm-9">
                <?= PriceTable::widget([
                    'id' => 'price' . $model->id,
                    'variants' => $model->variants,
                    'options' => [
                        'class' => 'table-sm',
                    ],
                ]) ?>
            </div>
            <div class="col-sm-3">
                <?php if ($variant->available !== 0): ?>
                    <button class="btn btn-primary btn-block btn-buy" rel="price<?= $model->id ?>"><?= $variant->available > 0 ? Yii::t('app', 'Buy') : Yii::t('app', 'To order') ?></button>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
