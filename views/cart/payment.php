<?php
/**
 * @var $this \yii\web\View
 * @var $model \dench\cart\models\Payment
 */

use dench\cart\models\Payment;

echo $model->text;

if (in_array($model->type, [Payment::TYPE_LIQPAY, Payment::TYPE_WFP])) {
    echo $this->render('_payment_card');
} else {
    $text = Yii::t('app', 'To order');
    $js = <<<JS
$('#submitButton').text('{$text}');
JS;
    $this->registerJs($js);
}