<?php

namespace app\models;

use dench\language\behaviors\LanguageBehavior;
use dench\products\models\Product;
use dench\sortable\behaviors\SortableBehavior;
use omgdef\multilingual\MultilingualQuery;
use voskobovich\linker\LinkerBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "podbor".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $position
 * @property int $enabled
 *
 * @property string $name
 * @property string $title
 * @property string $text
 *
 * @property Podbor $parent
 * @property Podbor[] $podbors
 * @property Product[] $products
 */
class Podbor extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'podbor';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            LanguageBehavior::className(),
            SortableBehavior::className(),
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
            [['name', 'title'], 'required'],
            [['parent_id', 'position'], 'integer'],
            [['enabled'], 'boolean'],
            [['enabled'], 'default', 'value' => true],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Podbor::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['name', 'title'], 'string', 'max' => 255],
            [['name', 'title'], 'trim'],
            [['text'], 'string'],
            [['product_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent'),
            'position' => Yii::t('app', 'Position'),
            'enabled' => Yii::t('app', 'Enabled'),
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Question'),
            'text' => Yii::t('app', 'Hint'),
        ];
    }

    /**
     * @return MultilingualQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Podbor::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPodbors()
    {
        return $this->hasMany(Podbor::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('podbor_product', ['podbor_id' => 'id']);
    }

    /**
     * @param boolean|null $enabled
     * @return array
     */
    public static function getList($enabled = null)
    {
        return ArrayHelper::map(self::find()->andFilterWhere(['enabled' => $enabled])->orderBy('position')->all(), 'id', 'name');
    }

    /**
     * @param integer|null $parent_id
     * @return array
     */
    public static function getParentList($parent_id = null)
    {
        return ArrayHelper::map(self::find()->where(['parent_id' => $parent_id, 'enabled' => true])->orderBy('position')->all(), 'id', 'name');
    }

    /**
     * @param integer $id
     * @return int
     */
    public static function getParentId($id)
    {
        return self::find()->select('parent_id')->where(['id' => $id, 'enabled' => true])->scalar();
    }

    /**
     * @param boolean|null $enabled
     * @return array
     */
    public static function getProductList($enabled = null)
    {
        return ArrayHelper::map(Product::find()->andFilterWhere(['enabled' => $enabled])->orderBy('position')->all(), 'id', 'name');
    }

    /**
     * @param integer $id
     * @return Podbor|ActiveRecord
     */
    public static function findOneEnabled($id)
    {
        return self::find()->where(['id' => $id, 'enabled' => true])->one();
    }
}
