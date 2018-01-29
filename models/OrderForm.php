<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 21.01.18
 * Time: 13:33
 */

namespace app\models;

use dench\products\models\Variant;
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
        $this->phone = Buyer::clearPhone($this->phone);

        $buyer = Buyer::findOne(['phone' => $this->phone]);

        if (empty($buyer)) {
            $buyer = new Buyer();
        }

        $buyer->name = ($this->name && $buyer->name != $this->name) ? $this->name : $buyer->name;
        $buyer->phone = ($this->phone && $buyer->phone != $this->phone) ? $this->phone : $buyer->phone;
        $buyer->delivery = ($this->delivery && $buyer->delivery != $this->delivery) ? $this->delivery : $buyer->delivery;
        $buyer->email = ($this->email && $buyer->email != $this->email) ? $this->email : $buyer->email;
        $buyer->entity = ($this->entity != null && $buyer->entity != $this->entity) ? $this->entity : $buyer->entity;

        if ($buyer->save()) {

            $cart = Cart::getCart();

            $product_ids = [];
            $amount = 0;

            $cartItemName = [];
            $cartItemCount = [];
            $cartItemPrice = [];

            foreach ($cart as $k => $v) {
                /** @var $item Variant */
                $item = Variant::find()->where(['id' => $k, 'enabled' => true])->one();
                if ($item) {
                    $cartItemName[$k] = $item->product->name . ', ' . $item->name;
                    $cartItemCount[$k] = $v;
                    $cartItemPrice[$k] = $item->price;
                    $product_ids[] = $item->id;
                    $amount += $v * $item->price;
                }
            }

            $order = new Order([
                'buyer_id' => $buyer->id,
                'product_ids' => $product_ids,
                'amount' => $amount,
                'cartItemName' => $cartItemName,
                'cartItemCount' => $cartItemCount,
                'cartItemPrice' => $cartItemPrice,
            ]);

            if ($order->save()) {
                Cart::clearCart();
                return true;
            }
        }

        return false;
    }
}