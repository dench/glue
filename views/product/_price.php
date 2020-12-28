<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:59
 *
 * @var $model dench\products\models\Product
 * @var $this yii\web\View
 * @var $rating array
 */

use app\widgets\PriceTable;

?>
<div class="row">
<?php if (@$model->variants[0]->price) { ?>
    <div class="col-sm-12">
        <?= $model->text_top ?>

        <div class="float-right text-nowrap my-3">
            <?php
            $floor = floor($rating['value']);
            for ($i = 0; $i < $floor; $i++) {
                echo '<i class="fa fa-star text-warning"></i> ';
            }
            if ($floor < $rating['value']) {
                echo '<i class="fa fa-star-half text-warning"></i> ';
            }
            ?>
            <a href="#reviews" class="text-muted ml-2"><?= Yii::$app->i18n->format('{n, plural, =0{нет отзывов} =1{1 отзыв} one{# отзыв} few{# отзыва} many{# отзывов} other{# отзывов}}', ['n' => $rating['count']], 'ru_RU'); ?></a>
        </div>

        <?php if ($model->variants[0]->available > 0): ?>
            <div class="text-success my-3"><i class="fa fa-check"></i> <?= Yii::t('app', 'In stock') ?></div>
        <?php elseif ($model->variants[0]->available < 0): ?>
            <div class="text-warning my-3"><i class="fa fa-clock-o"></i> <?= Yii::t('app', 'On order') ?></div>
        <?php else: ?>
            <div class="text-danger my-3"><i class="fa fa-times"></i> <?= Yii::t('app', 'Not available') ?></div>
        <?php endif; ?>

        <?= PriceTable::widget([
            'id' => 'price' . $model->id,
            'variants' => $model->variants,
        ]) ?>

        <div class="row">
            <div class="col">
                <?php if ($model->variants[0]->available !== 0): ?>
                    <button class="btn btn-primary btn-block btn-buy" rel="price<?= $model->id ?>"><?= $model->variants[0]->available > 0 ? Yii::t('app', 'Buy') : Yii::t('app', 'To order') ?></button>
                <?php endif; ?>
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