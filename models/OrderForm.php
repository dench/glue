<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 21.01.18
 * Time: 13:33
 */

namespace app\models;

use himiklab\yii2\recaptcha\ReCaptchaValidator;
use Yii;
use yii\base\Model;

class OrderForm extends Model
{
    public $name;
    public $phone;
    public $email;
    public $delivery;
    public $entity;
    public $policy;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'policy'], 'required'],
            [['name', 'phone', 'email', 'delivery'], 'string'],
            ['email', 'email'],
            [['entity', 'policy'], 'boolean'],
            //['reCaptcha', ReCaptchaValidator::className(), 'uncheckedMessage' => Yii::t('app', 'Пожалуйста, подтвердите, что вы не бот.')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'ФИО',
            'phone' => 'Контактный телефон',
            'email' => 'Ваш E-mail',
            'delivery' => 'Город для доставки',
            'entity' => 'Покупателем выступает',
        ];
    }

    public function send()
    {
        /*$buyer_old = Buyer::findOne(['phone' => $this->phone]);

        if ($buyer_old) {
            $buyer = $buyer_old;
        } else {
            $buyer = new Buyer();
        }

        $order = new Order([
            'name' => $this->name,
            'email' => $this->email,
            'question' => $this->text,
        ]);

        if ($model->save()) {
            return true;
        } else {
            return false;
        }*/
    }
}