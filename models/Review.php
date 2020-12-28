<?php

namespace app\models;

use dench\products\models\Product;
use dench\sortable\behaviors\SortableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "review".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $answer
 * @property string $email
 * @property integer $rating
 * @property integer $created_at
 * @property integer $position
 * @property integer $status
 * @property integer|null $product_id
 *
 * @property Product $product
 */
class Review extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_NEW = 1;
    const STATUS_UNPUBLISHED = 2;
    const STATUS_PUBLISHED = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
            SortableBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rating'], 'required'],
            [['text', 'answer'], 'string'],
            [['rating', 'created_at', 'position', 'status', 'product_id'], 'integer'],
            [['name', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['status', 'default', 'value' => self::STATUS_NEW],
            ['status', 'in', 'range' => [self::STATUS_DELETED, self::STATUS_NEW, self::STATUS_UNPUBLISHED, self::STATUS_PUBLISHED]],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'text' => 'Текст отзыва',
            'answer' => 'Ответ',
            'email' => 'E-mail',
            'rating' => 'Оценка',
            'created_at' => 'Создан',
            'position' => 'Позиция',
            'status' => 'Статус',
            'product_id' => 'Товар',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public static function unread()
    {
        return self::find()->where(['status' => self::STATUS_NEW])->count();
    }

    public static function read($id = null)
    {
        /** @var $temp Review[] */
        $temp = self::find()->where(['status' => self::STATUS_NEW])->andFilterWhere(['id' => $id])->all();

        foreach ($temp as $t) {
            $t->status = self::STATUS_UNPUBLISHED;
            $t->save();
        }
    }

    public static function statusList()
    {
        return [
            self::STATUS_DELETED => 'Удаленный',
            self::STATUS_NEW => 'Новый',
            self::STATUS_UNPUBLISHED => 'Неопубликованный',
            self::STATUS_PUBLISHED => 'Опубликованный',
        ];
    }
}
