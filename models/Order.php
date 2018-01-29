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
 * @property array $product_ids
 *
 * @property Buyer $buyer
 * @property Variant[] $products
 */
class Order extends ActiveRecord
{
    public $cartItemName = [];
    public $cartItemCount = [];
    public $cartItemPrice = [];

    const STATUS_NEW = 1;
    const STATUS_OLD = 2;

    public function init()
    {
        $this->cartItemName = $this->getCartItemName();
        $this->cartItemCount = $this->getCartItemCount();
        $this->cartItemPrice = $this->getCartItemPrice();
    }

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
                    'product_ids' => [
                        'products',
                        'updater' => [
                            'viaTableAttributesValue' => [
                                'name' => function($updater, $relatedPk, $rowCondition) {
                                    $primaryModel = $updater->getBehavior()->owner;
                                    return @$primaryModel->cartItemName[$relatedPk];
                                },
                                'count' => function($updater, $relatedPk, $rowCondition) {
                                    $primaryModel = $updater->getBehavior()->owner;
                                    return @$primaryModel->cartItemCount[$relatedPk];
                                },
                                'price' => function($updater, $relatedPk, $rowCondition) {
                                    $primaryModel = $updater->getBehavior()->owner;
                                    return @$primaryModel->cartItemPrice[$relatedPk];
                                },
                            ],
                        ],
                    ],
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
            [['buyer_id', 'amount', 'product_ids'], 'required'],
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
        return $this->hasMany(Variant::className(), ['id' => 'variant_id'])->viaTable('order_product', ['order_id' => 'id']);
    }

    public static function unread()
    {
        return self::find()->where(['status' => self::STATUS_NEW])->count();
    }

    public static function read($id = null)
    {
        /** @var $temp Order[] */
        $temp = self::find()->where(['status' => self::STATUS_NEW])->andFilterWhere(['id' => $id])->all();

        foreach ($temp as $t) {
            $t->status = self::STATUS_OLD;
            $t->save();
        }
    }

    public function getCartItemName()
    {
        return OrderProduct::find()->select(['name'])->indexBy('variant_id')->asArray()->column();
    }

    public function getCartItemCount()
    {
        return OrderProduct::find()->select(['count'])->indexBy('variant_id')->asArray()->column();
    }

    public function getCartItemPrice()
    {
        return OrderProduct::find()->select(['price'])->indexBy('variant_id')->asArray()->column();
    }

    public static function statusList()
    {
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_OLD => 'Старый',
        ];
    }
}
