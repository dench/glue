<?php

namespace app\models;

use dench\products\models\Variant;
use voskobovich\linker\LinkerBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $buyer_id
 * @property int $amount
 * @property string $text
 * @property int $created_at
 * @property int $status
 *
 * @property Buyer $buyer
 * @property OrderProduct[] $orderProducts
 */
class Order extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_OLD = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
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
            [
                'class' => LinkerBehavior::className(),
                'relations' => [
                    'product_ids' => ['products'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['buyer_id', 'amount'], 'required'],
            [['buyer_id', 'amount', 'status'], 'integer'],
            [['text'], 'string'],
            ['status', 'default', 'value' => self::STATUS_NEW],
            ['status', 'in', 'range' => [self::STATUS_NEW, self::STATUS_OLD]],
            [['product_ids'], 'each', 'rule' => ['integer']],
            [['buyer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Buyer::className(), 'targetAttribute' => ['buyer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'buyer_id' => Yii::t('app', 'Buyer'),
            'amount' => Yii::t('app', 'Amount'),
            'text' => Yii::t('app', 'Text'),
            'created_at' => Yii::t('app', 'Created'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyer()
    {
        return $this->hasOne(Buyer::className(), ['id' => 'buyer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
        //return $this->hasMany(Order::className(), ['id' => 'order_id'])->viaTable('order_product', ['variant_id' => 'id']);
    }
}
