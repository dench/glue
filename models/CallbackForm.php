<?php

namespace app\models;

use himiklab\yii2\recaptcha\ReCaptchaValidator;
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
            [['reCaptcha'],
                ReCaptchaValidator::class,
                'skipOnEmpty' => YII_DEBUG ? true : false,
                'uncheckedMessage' => Yii::t('app', 'Please confirm that you are not a bot.'),
                'enableClientValidation' => false,
            ],
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
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->name])
                ->setSubject(Yii::t('app', 'Callback'))
                ->setTextBody($text)
                ->send();

            return true;
        }
        return false;
    }
}
