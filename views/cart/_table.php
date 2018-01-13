<?php
/* @var $this yii\web\View */
/* @var $items dench\products\models\Variant[] */
/* @var $cart array */

use dench\image\helpers\ImageHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$url_del = Url::to('/cart/del');
$url_set = Url::to('/cart/set');

$js = <<<JS
$('.product-delete').click(function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    console.log(id);
    $.get('{$url_del}', { id: id }, function(data){
        if (data) {
            $('#i' + id).fadeOut('normal', function(){
                $(this).remove();
                calculate();
            });
        }
    });
});
$('.product-count').keyup(function(){
    $.get('{$url_set}', { id: $(this).attr('data-id'), count: $(this).val()}, function(){
        calculate();
    });
});
function calculate() {
    var total = 0;
    $('.product-count').each(function(){
        var sum = $(this).val() * $(this).attr('data-price');
        total += sum;
        $(this).parents('tr').find('.sum').text(sum);
    });
    $('.total').text(total);
}
calculate();
JS;

$this->registerJs($js);
?>
<?php if ($items) : ?>
<div class="table-responsive">
    <table class="table table-sm table-bordered bg-white text-center align-middle">
        <tbody>
        <tr class="bg-gradient-secondary text-white">
            <th>№</th>
            <th><?= Yii::t('app', 'Photo') ?></th>
            <th><?= Yii::t('app', 'Product name') ?></th>
            <th><?= Yii::t('app', 'Packing') ?></th>
            <th><?= Yii::t('app', 'Count') ?></th>
            <th><?= Yii::t('app', 'Delete') ?></th>
            <th><?= Yii::t('app', 'Price per unit') . ', ' . $items[0]->currency->before . $items[0]->currency->after ?></th>
            <th><?= Yii::t('app', 'Amount') . ', ' . $items[0]->currency->before . $items[0]->currency->after ?></th>
        </tr>
        <?php foreach ($items as $k => $item) : ?>
            <tr id="i<?= $item->id ?>" rel="<?= $item->id ?>">
                <td><?= $k + 1 ?></td>
                <td>
                    <?= Html::a(Html::img(ImageHelper::thumb($item->product->image->id, 'micro'), ['height' => '70']), ['product/index', 'slug' => $item->product->slug]) ?>
                </td>
                <td class="text-left">
                    <?= Html::a($item->product->name, ['product/index', 'slug' => $item->product->slug]) ?>
                </td>
                <td>
                    <?= $item->name ?>
                </td>
                <td>
                    <?= Html::textInput('Count[]', $cart[$item->id], ['class' => 'form-control text-center form-control-sm product-count', 'size' => 1, 'data-id' => $item->id, 'data-price' => $item->price]) ?>
                </td>
                <td>
                    <a href="#" class="btn btn-link btn-sm text-danger product-delete" rel="<?= $item->id ?>"><i class="fa fa-trash fa-lg"></i></a>
                </td>
                <td>
                    <?= $item->price ?>
                </td>
                <td class="sum"></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="text-right">
    <?= Yii::t('app', 'Total amount') ?>: <b><?= $items[0]->currency->before . '<span class="total">0</span>' . $items[0]->currency->after ?></b>
</div>
<?php else: ?>
<div class="alert alert-warning">
    <?= Yii::t('app', 'Cart empty') ?>
</div>
<?php endif; ?>
