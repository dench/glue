<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 20.01.18
 * Time: 13:01
 */

namespace app\widgets;

use dench\products\models\Variant;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

class PriceTable extends Widget
{
    public $id;

    public $variants;

    public $urlCartAdd = ['/cart/add'];

    public $options = [];

    public $originalPrice = false;

    public $available;

    public function run()
    {
        /** @var $variants Variant[] */
        $variants = [];

        foreach ($this->variants as $variant) {
            if ($variant->enabled) {
                $variants[] = $variant;
            }
        }

        if (empty($variants)) {
            return '';
        }

        $this->registerClientScript();

        $cols[] = Html::tag('th', Yii::t('app', 'Volume') . ':');

        foreach ($variants as $variant) {
            $availableClass = 'on-order';
            if ($variant->available === 0) {
                $availableClass = 'not-available';
            } elseif ($variant->available === 1) {
                $availableClass = 'in-stock';
            }
            $cols[] = Html::tag('td', Html::radio('buy[' . $variant->product_id . ']', false, ['value' => $variant->id]) . ' ' . $variant->name, ['class' => $availableClass]);
        }

        $tr[] = Html::tag('tr', implode("\n", $cols));

        unset($cols);

        $cols[] = Html::tag('th', Yii::t('app', 'Price') . ':');

        foreach ($variants as $variant) {
            $originalPrice = null;
            if ($this->originalPrice) {
                $originalPrice .= ' (' . ($variant->currency->before . $variant->price . $variant->currency->after) . ')';
            }
            $hide = $this->available === $variant->available ? ' d-none' : '';
            if ($variant->available > 0) {
                $available = Html::tag('div', '<i class="fa fa-check"></i> ' . Yii::t('app', 'In stock'), ['class' => 'available in-stock text-success' . $hide, 'rel' => Yii::t('app', 'Buy')]);
            } elseif ($variant->available < 0) {
                $available = Html::tag('div', '<i class="fa fa-clock-o"></i> ' . Yii::t('app', 'On order'), ['class' => 'available on-order text-warning' . $hide, 'rel' => Yii::t('app', 'To order')]);
            } else {
                $available = Html::tag('div', '<i class="fa fa-times"></i> ' . Yii::t('app', 'Not available'), ['class' => 'available not-available text-danger' . $hide]);
            }
            $cols[] = Html::tag('td', $variant->currencyDef->before . $variant->priceDef . $variant->currencyDef->after . $originalPrice . $available);
        }

        $tr[] = Html::tag('tr', implode("\n", $cols));

        $tbody = Html::tag('tbody', implode("\n", $tr));

        $options = [
            'id' => $this->id,
            'class' => 'table table-default table-bordered table-price text-center bg-white',
        ];

        $optionsClass = ArrayHelper::remove($this->options, 'class');

        $options = array_merge($options, $this->options);

        Html::addCssClass($options, $optionsClass);

        return Html::tag('table', $tbody, $options);
    }

    private function registerClientScript()
    {
        $url_add = Url::to($this->urlCartAdd);

        $url_cart_modal = Url::to(['/cart/modal']);

        $js = <<< JS
var eq = 0;
$('.table-price tr').each(function(index){
    var obj = $(this).parents('table');
    $(this).find('td').mouseenter(function(){
        var i = $(this).index();
        obj.find('tr').each(function(){
            $(this).find('td').eq(i-1).addClass('over');
        });
    }).mouseleave(function(){
        var i = $(this).index();
        obj.find('tr').each(function(){
            $(this).find('td').eq(i-1).removeClass('over');
        });
    }).click(function(){
        var i = $(this).index();
        obj.find('tr').each(function(index3){
            $(this).find('input').prop('checked', false);
            $(this).find('td').removeClass('active').eq(i-1).each(function(){
                if (index3) {
                    var oo = obj.closest('.row').parent().closest('.row');
                    var o = $(this).find('.available');
                    if (o.hasClass('not-available')) {
                        oo.find('.btn-buy').hide();
                    } else if (o.hasClass('in-stock')) {
                        oo.find('.btn-buy').show().text(o.attr('rel'));
                    } else if (o.hasClass('on-order')) {
                        oo.find('.btn-buy').show().text(o.attr('rel'));
                    }
                    oo.find('.stock').html(o.clone().removeClass('d-none'));
                }
            }).addClass('active').find('input').prop('checked', true);
        });
    }).each(function(index2){
        if (!index && !eq && $(this).hasClass('in-stock')) {
            eq = index2;
            return false;
        }
    }).eq(eq).addClass('active').find('input').prop('checked', true);
    if (index) {
        eq = 0;
    }
});
$('.btn-buy').mousedown(function(){
    var id = $('#' + $(this).attr('rel') + ' input:checked').val();
    $.get('{$url_add}', { id: id }, function(){
        openModal('{$url_cart_modal}');
    });
});
JS;
        $this->view->registerJs($js, View::POS_READY, 'jsPriceTable');
    }
}