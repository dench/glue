<?php

use yii\widgets\MaskedInput;

echo MaskedInput::widget([
    'id' => 'orderform-delivery',
    'name' => 'OrderForm[delivery]',
    'mask' => '*{0,100}',
    'definitions' => [
        '&' => [
            'validator' => "[0-9/]",
            'cardinality' => 1,
            'casing' => 'lower',
        ],
    ],
    'options' => [
        'class' => 'form-control',
        'placeholder' => Yii::t('app', 'Enter the city and shipping address'),
    ],
]);