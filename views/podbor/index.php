<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */

use app\components\ActiveForm;
use app\models\Podbor;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->params['breadcrumbs'][] = $page->name;

$resultUrl = Url::to(['result']);

$js = <<<JS
function loadProducts(id) {
    $('#result').load('{$resultUrl}', { id: id });
}

var emptyHelp = 'Выберите вариант<br> из выпадающего списка';

$('[data-toggle="popover"]').popover({ html: true });

$('.field-step1').find('.btn-help').attr('data-content', emptyHelp);
JS;
$this->registerJs($js);
?>
<h1 class="mb-3"><?= $page->h1 ?></h1>

<?= $page->short ?>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'horizontalLabelClass' => Yii::$app->params['podbor']['horizontalLabelClass'],
    'horizontalInputClass' => Yii::$app->params['podbor']['horizontalInputClass'],
    'options' => [
        'class' => 'mb-4',
    ],
    'horizontalTemplate' => "{label}
<div class=\"{horizontalInputClass}\">
    <div class=\"input-group\">
        {input}
        <div class=\"input-group-append\">
            <button type=\"button\" class=\"btn btn-secondary btn-help\" tabindex=\"0\" data-toggle=\"popover\" data-trigger=\"focus\" data-content=\"\">
                <i class=\"fa fa-question-circle fa-lg\"></i>
            </button>
        </div>
    </div>
    {hint}
    {error}
</div>",
]); ?>

<?= $form->field($model, 'step[]')->dropDownList(Podbor::getParentList(), [
    'id' => 'step1',
    'prompt' => Yii::t('app', 'Select...'),
])->label('Поставленная задача:'); ?>

<?= $form->field($model, 'step[]', ['options' => ['class' => 'form-group row d-none']])->widget(DepDrop::classname(), [
    'options' => ['id' => 'step2'],
    'pluginOptions' => [
        'depends' => ['step1'],
        'placeholder' => Yii::t('app', 'Select...'),
        'url' => Url::to(['/podbor/child-list'])
    ],
    'pluginEvents' => [
        'depdrop:change' =>
new JsExpression("
function(event, id, value, count) {
    $('.field-step2, .field-step3, .field-step4, .field-step5').addClass('d-none');
    if (count) {
        $('#result').text('');
        var result = $('#step2').depdrop('getAjaxResults');
        $('.field-step2').removeClass('d-none').find('.col-form-label').text(result.label);
        if (result.help === '') result.help = emptyHelp;
        $('.field-step2').find('.btn-help').attr('data-content', result.help);
    } else {
        if (value) loadProducts(value);
    }
}
"),
    ],
]); ?>

<?= $form->field($model, 'step[]', ['options' => ['class' => 'form-group row d-none']])->widget(DepDrop::classname(), [
    'options' => ['id' => 'step3'],
    'pluginOptions' => [
        'depends' => ['step2'],
        'placeholder' => Yii::t('app', 'Select...'),
        'url' => Url::to(['/podbor/child-list'])
    ],
    'pluginEvents' => [
        'depdrop:change' => new JsExpression("
function(event, id, value, count) {
    $('.field-step3, .field-step4, .field-step5').addClass('d-none');
    if (count) {
        $('#result').text('');
        var result = $('#step3').depdrop('getAjaxResults');
        $('.field-step3').removeClass('d-none').find('.col-form-label').text(result.label + ':');
        if (result.help === '') result.help = emptyHelp;
        $('.field-step3').find('.btn-help').attr('data-content', result.help);
    } else {
        if (value) loadProducts(value);
    }
}
"),
    ],
]); ?>

<?= $form->field($model, 'step[]', ['options' => ['class' => 'form-group row d-none']])->widget(DepDrop::classname(), [
    'options' => ['id' => 'step4'],
    'pluginOptions' => [
        'depends' => ['step3'],
        'placeholder' => Yii::t('app', 'Select...'),
        'url' => Url::to(['/podbor/child-list'])
    ],
    'pluginEvents' => [
        'depdrop:change' => new JsExpression("
function(event, id, value, count) {
    $('.field-step4, .field-step5').addClass('d-none');
    if (count) {
        $('#result').text('');
        var result = $('#step4').depdrop('getAjaxResults');
        $('.field-step4').removeClass('d-none').find('.col-form-label').text(result.label + ':');
        if (result.help === '') result.help = emptyHelp;
        $('.field-step4').find('.btn-help').attr('data-content', result.help);
    } else {
        if (value) loadProducts(value);
    }
}
"),
    ],
]); ?>

<?= $form->field($model, 'step[]', ['options' => ['class' => 'form-group row d-none']])->widget(DepDrop::classname(), [
    'options' => ['id' => 'step5'],
    'pluginOptions' => [
        'depends' => ['step4'],
        'placeholder' => Yii::t('app', 'Select...'),
        'url' => Url::to(['/podbor/child-list'])
    ],
    'pluginEvents' => [
        'depdrop:change' => new JsExpression("
function(event, id, value, count) {
    if (count) {
        $('#result').text('');
        var result = $('#step5').depdrop('getAjaxResults');
        $('.field-step5').removeClass('d-none').find('.col-form-label').text(result.label + ':');
        if (result.help === '') result.help = emptyHelp;
        $('.field-step5').find('.btn-help').attr('data-content', result.help);
    } else {
        if (value) loadProducts(value);
    }
}
"),
    ],
]); ?>

<?php ActiveForm::end(); ?>

<div id="result"></div>

<?= $page->text ?>