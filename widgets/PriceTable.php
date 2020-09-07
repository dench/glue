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
            $cols[] = Html::tag('td', Html::radio('buy[' . $variant->product_id . ']', false, ['value' => $variant->id]) . ' ' . $variant->name);
        }

        $tr[] = Html::tag('tr', implode("\n", $cols));

        unset($cols);

        $cols[] = Html::tag('th', Yii::t('app', 'Price') . ':');

        foreach ($variants as $variant) {
            $originalPrice = null;
            if ($this->originalPrice) {
                $originalPrice .= ' (' . ($variant->currency->before . $variant->price . $variant->currency->after) . ')';
            }
            $cols[] = Html::tag('td', $variant->currencyDef->before . $variant->priceDef . $variant->currencyDef->after . $originalPrice);
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

        $js = <<< JS
$('.table-price tr').each(function(){
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
        obj.find('tr').each(function(){
            $(this).find('input').prop('checked', false);
            $(this).find('td').removeClass('active').eq(i-1).addClass('active').find('input').prop('checked', true);
        });
    }).first().addClass('active').find('input').prop('checked', true);
});
$('.btn-buy').mousedown(function(){
    var id = $('#' + $(this).attr('rel') + ' input:checked').val();
    $.get('{$url_add}', { id: id }, function(){
        openModal('/cart/modal');
    });
});
JS;
        $this->view->registerJs($js, View::POS_READY, 'jsPriceTable');
    }
}