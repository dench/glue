<?php
/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */
/* @var $items dench\products\models\Variant[] */
/* @var $cart array */
/* @var $order dench\cart\models\Order */
/* @var $model dench\cart\models\OrderForm */

use app\components\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->params['breadcrumbs'][] = $page->name;
?>
<h1 class="mb-3"><?= $page->h1 ?></h1>

<?php if (Yii::$app->session->hasFlash('orderSubmitted')): ?>

    <div class="alert alert-success">
        Заказ успешно отправлен. Скоро с вами свяжется наш сотрудник для уточнения информации.
    </div>

<?php

$products = [];

foreach ($order->orderProducts as $product) {
    $products[] = "{
    'sku': '{$product->variant->product_id}',
    'name': '{$product->variant->product->name}, {$product->variant->name}',
    'category': '{$product->variant->product->categories[0]->name}',
    'price': '{$product->variant->price}',
    'quantity': '{$product->count}'
}";
}

$transactionProducts = implode(',', $products);

$js = <<<JS
dataLayer = [{
    'transactionId': '{$order->id}',
    'transactionTotal': '{$order->amount}',
    'transactionProducts': [{$transactionProducts}]
}];
JS;
$this->registerJs($js, \yii\web\View::POS_HEAD);
?>

<?php else: ?>

    <?= $page->short ?>
    <?= $page->text ?>

    <?= $this->render('_table', [
        'items' => $items,
        'cart' => $cart,
    ]) ?>

    <?php if ($items) : ?>

        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
        ]) ?>

        <div class="card my-4">
            <div class="card-body">
                <div class="h1 text-center mb-3">Необходимая информация для заказа</div>

                <?= $form->field($model, 'name')->textInput(['placeholder' => 'Фамилия Имя Отчество']) ?>

                <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                    'mask' => '+38 (099) 999-99-99',
                ]) ?>

                <?php if (!YII_DEBUG): ?>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::className())->label(false) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="h2 text-center mb-3">Дополнительная информация о себе</div>

                <div class="mb-4">
                    Если хотите, можете указать дополнительную информацию о себе.
                    Это позволит нашим сотрудникам быстрее подготовить и отправить
                    Вам счет на оплату заказанной продукции.
                </div>

                <?= $form->field($model, 'delivery')->widget(MaskedInput::className(), [
                    'mask' => 'город *{3,20}, отделение новой почты № 9{1,4}',
                ])->textInput(['placeholder' => 'Введите город и номер отделения Новой почты']) ?>

                <?= $form->field($model, 'email')->textInput()->hint('Ваш адрес email не будет опубликован.') ?>

                <?= $form->field($model, 'entity')->radioList([
                    0 => 'Частное лицо',
                    1 => 'Организация',
                ], ['class' => 'pt-2']) ?>

            </div>
        </div>



        <div class="text-muted">
            <b class="text-danger">*</b> - поля являются обязательными для заполнения<br>
            Просьба указывать дополнительную информацию - это поможет нам быстрее обработать Ваш заказ.
        </div>

        <div class="text-center mt-4">
            <?= Html::submitButton('Заказать', ['class' => 'btn btn-primary btn-lg']) ?>
        </div>

        <?php ActiveForm::end() ?>

    <?php endif; ?>

<?php endif; ?>