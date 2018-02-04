<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:59
 *
 * @var $model dench\products\models\Product
 * @var $this yii\web\View
 */

use app\widgets\PriceTable;

?>
<div class="row">
<?php if (@$model->variants[0]->price) { ?>
    <div class="col-sm-12">
        <?= $model->text_top ?>
        <?php if ($model->variants[0]->available > 0): ?>
            <div class="text-success my-3"><i class="fa fa-check"></i> <?= Yii::t('app', 'In stock') ?></div>
        <?php else: ?>
            <div class="text-danger my-3"><i class="fa fa-times"></i> <?= Yii::t('app', 'Not available') ?></div>
        <?php endif; ?>

        <?= PriceTable::widget([
            'id' => 'price' . $model->id,
            'variants' => $model->variants,
        ]) ?>

        <div class="row">
            <div class="col">
                <button class="btn btn-primary btn-block btn-buy" rel="price<?= $model->id ?>"><?= Yii::t('app', 'Buy') ?></button>
            </div>
            <div class="col">
                <span class="btn btn-link" onclick="window.print();"><i class="fa fa-print"></i> Версия для печати</span>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
<?php } else {?>
    <div class="col-sm-12">
<?php } ?>
    </div>
</div>