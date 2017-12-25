<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 24.12.17
 * Time: 15:46
 */

namespace app\models;

use himiklab\yii2\recaptcha\ReCaptchaValidator;
use Yii;
use yii\base\Model;

class ReviewForm extends Model
{
    public $name;
    public $email;
    public $text;
    public $rating;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text', 'email', 'rating'], 'required'],
            [['name', 'text', 'email'], 'string'],
            ['rating', 'integer'],
            ['email', 'email'],
            ['reCaptcha', ReCaptchaValidator::className(), 'uncheckedMessage' => Yii::t('app', 'Пожалуйста, подтвердите, что вы не бот.')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Ваш E-mail',
            'text' => 'Текст отзыва',
            'rating' => 'Оценка',
        ];
    }

    public function send()
    {
        $model = new Review([
            'name' => $this->name,
            'email' => $this->email,
            'text' => $this->text,
            'rating' => $this->rating,
        ]);

        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }
}