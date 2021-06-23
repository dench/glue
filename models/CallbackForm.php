<?php

namespace app\models;

use Exception;
use himiklab\yii2\recaptcha\ReCaptchaValidator2;
use Yii;
use yii\base\Model;

/**
 * CallbackForm is the model behind the contact form.
 */
class CallbackForm extends Model
{
    public $name;
    public $phone;
    public $reCaptcha;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'required'],
            [['name', 'phone'], 'string'],
            [['reCaptcha'], ReCaptchaValidator2::class, 'uncheckedMessage' => Yii::t('app', 'Please confirm that you are not a bot.')],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Your name'),
            'phone' => Yii::t('app', 'Your phone'),
            'reCaptcha' => Yii::t('app', 'Verification'),
        ];
    }

    /**
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function send($email)
    {
        $text = $this->name . ' ' . $this->phone;

        if ($this->validate()) {
            try {
                Yii::$app->mailer->compose()
                    ->setTo($email)
                    ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->name])
                    ->setSubject(Yii::t('app', 'Callback'))
                    ->setTextBody($text)
                    ->send();
            } catch (Exception $e) {
                Yii::$app->mailer->compose()
                    ->setTo($email)
                    ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->name])
                    ->setSubject('Ошибка отправки почты. ' . Yii::t('app', 'Callback'))
                    ->setTextBody('Ошибка отправки почты, сообщите разработчику. ' . $text)
                    ->send();
            }
            return true;
        }
        return false;
    }
}
