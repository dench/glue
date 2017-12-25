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

class QuestionForm extends Model
{
    public $name;
    public $email;
    public $text;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text', 'email'], 'required'],
            [['name', 'text', 'email'], 'string'],
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
            'text' => 'Ваш вопрос',
        ];
    }

    public function send()
    {
        $model = new Question([
            'name' => $this->name,
            'email' => $this->email,
            'question' => $this->text,
        ]);

        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }
}