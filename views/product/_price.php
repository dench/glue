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

use yii\helpers\Html;

$url_add = \yii\helpers\Url::to(['/cart/add']);

$js = <<< JS
$('.table-price tr').each(function(){
    $(this).find('td').mouseenter(function(){
        var i = $(this).index();
        $('.table-price tr').each(function(){
            $(this).find('td').eq(i-1).addClass('over');
        });
    }).mouseleave(function(){
        var i = $(this).index();
        $('.table-price tr').each(function(){
            $(this).find('td').eq(i-1).removeClass('over');
        });
    }).click(function(){
        var i = $(this).index();
        $('.table-price tr').each(function(){
            $(this).find('input').prop('checked', false);
            $(this).find('td').removeClass('active').eq(i-1).addClass('active').find('input').prop('checked', true);
        });
    }).first().addClass('active').find('input').prop('checked', true);
});
$('.btn-buy').mousedown(function(){
    var id = $('.table-price input:checked').val();
    $.get('{$url_add}', { id: id }, function(){
        openModal('/cart/modal');
    });
});
JS;

$this->registerJs($js);
?>
<div class="row">
<?php if (@$model->variants[0]->price) { ?>
    <div class="col-sm-12">
        <?= nl2br($model->description) ?>
        <?php if ($model->variants[0]->available > 0): ?>
            <div class="text-success my-3"><i class="fa fa-check"></i> <?= Yii::t('app', 'In stock') ?></div>
        <?php else: ?>
            <div class="text-danger my-3"><i class="fa fa-times"></i> <?= Yii::t('app', 'Not available') ?></div>
        <?php endif; ?>
        <table class="table table-default table-bordered table-price text-center">
            <tbody>
                <tr>
                    <th><?= Yii::t('app', 'Volume') ?>:</th>
                    <?php foreach ($model->variants as $variant) : ?>
                        <td><?= $variant->name ?><br><?= Html::radio('buy', false, ['value' => $variant->id]) ?></td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <th><?= Yii::t('app', 'Price') ?>:</th>
                    <?php foreach ($model->variants as $variant) : ?>
                        <td><?= $variant->currency->before ?><?= $variant->price ?><?= $variant->currency->after ?></td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col">
                <button class="btn btn-primary btn-block btn-buy"><?= Yii::t('app', 'Buy') ?></button>
            </div>
            <div class="col">

            </div>
        </div>
    </div>
    <div class="col-sm-12">
<?php } else {?>
    <div class="col-sm-12">
<?php } ?>
    </div>
</div>