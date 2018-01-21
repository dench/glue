<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "buyer".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property int $created_at
 * @property boolean $entity
 * @property string $delivery
 *
 * @property Order[] $orders
 */
class Buyer extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'buyer';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'required'],
            [['entity'], 'boolean'],
            [['name', 'email', 'delivery'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'E-mail'),
            'created_at' => Yii::t('app', 'Created'),
            'entity' => Yii::t('app', 'Entity'),
            'delivery' => Yii::t('app', 'Delivery'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['buyer_id' => 'id']);
    }
}