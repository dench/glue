<?php

namespace app\models;

use dench\language\behaviors\LanguageBehavior;
use dench\sortable\behaviors\SortableBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu_item".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $parent_id
 * @property string $icon
 * @property string $url
 * @property string $link
 * @property integer $position
 * @property integer $enabled
 * @property string $label
 *
 * @property Menu $menu
 * @property MenuItem $parent
 * @property MenuItem[] $menuItems
 */
class MenuItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            LanguageBehavior::className(),
            SortableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'label'], 'required'],
            [['menu_id', 'parent_id', 'position', 'enabled'], 'integer'],
            [['icon'], 'string', 'max' => 32],
            [['url', 'link', 'icon'], 'trim'],
            [['url', 'link'], 'string', 'max' => 255],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItem::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['label'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => Yii::t('app', 'Menu'),
            'parent_id' => Yii::t('app', 'Parent'),
            'icon' => Yii::t('app', 'Icon'),
            'url' => Yii::t('app', 'Url'),
            'link' => Yii::t('app', 'Link'),
            'position' => Yii::t('app', 'Position'),
            'enabled' => Yii::t('app', 'Enabled'),
            'label' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['parent_id' => 'id']);
    }

    /**
     * @return MultilingualQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public static function dropDownList($condition = null)
    {
        return ArrayHelper::map(self::find()->where($condition)->orderBy(['position' => SORT_ASC])->all(), 'id', 'label');
    }
}
