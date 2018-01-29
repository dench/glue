<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 20.01.18
 * Time: 19:14
 *
 * @var $page dench\page\models\Page
 * @var $model app\models\OrderForm
 */

use app\components\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cart'), 'url' => ['/cart/index']];
$this->params['breadcrumbs'][] = $page->name;
?>
<?= $page->text ?>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
]) ?>

    <div class="card mb-4">
        <div class="card-body">
            <div class="h1 text-center mb-3">Необходимая информация для заказа</div>

            <?= $form->field($model, 'name')->textInput(['placeholder' => 'Фамилия Имя Отчество']) ?>

            <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                'mask' => '+38 (099) 999-99-99',
            ]) ?>

            <div class="row">
                <div class="col-sm-3">

                </div>
                <div class="col-sm-9">
                    <?= Html::activeCheckbox($model, 'policy', ['value' => 1, 'checked' => false, 'required' => true, 'label' => '<span class="text-muted">Я ознакомлен с <a href="' . \yii\helpers\Url::to(['site/page', 'slug' => 'policy']) . '">политикой сайта о конфиденциальности</a> и согласен отправить указанные мной данные на обработку</span>']) ?>
                </div>
            </div>

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

            <?= $form->field($model, 'email')->textInput() ?>

            <?= $form->field($model, 'delivery')->widget(MaskedInput::className(), [
                'mask' => 'город *{3,20}, отделение новой почты № 9{1,4}',
            ])->textInput(['placeholder' => 'Введите город и номер отделения Новой почты']) ?>

            <?= $form->field($model, 'entity')->radioList([
                0 => 'Частное лицо ',
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