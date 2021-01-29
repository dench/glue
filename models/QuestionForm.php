<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 24.12.17
 * Time: 15:46
 */

namespace app\models;

use himiklab\yii2\recaptcha\ReCaptchaValidator2;
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
            ['reCaptcha', ReCaptchaValidator2::class, 'uncheckedMessage' => Yii::t('app', 'Please confirm that you are not a bot.')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Your name'),
            'email' => Yii::t('app', 'Your E-mail'),
            'text' => Yii::t('app', 'Your question'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'email' => Yii::t('app', 'This E-mail address will not be published'),
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