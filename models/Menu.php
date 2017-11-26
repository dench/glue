<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $enabled
 *
 * @property MenuItem[] $menuItems
 */
class Menu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['enabled'], 'boolean'],
            [['name'], 'string', 'max' => 255],
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
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['menu_id' => 'id']);
    }

    public static function dropDownList($condition = null)
    {
        return self::find()->select(['name'])->where($condition)->asArray()->indexBy('id')->column();
    }

    public static function getItemsForWidget($id)
    {
        $temp = self::findOne($id)->getMenuItems()->indexBy('id')->orderBy(['position' => SORT_ASC])->all();

        $items = [];

        foreach ($temp as $i => $t) {
            if ($t->link) {
                $url = $t->link;
            } else if ($t->url) {
                $url = [$t->url];
            } else {
                $url = "#";
            }
            if (empty($t['parent_id'])) {
                $items[$i]['label'] = $t->label;
                $items[$i]['url'] = $url;
            } else {
                $items[$t['parent_id']]['items'][$i] = [
                    'label' => $t->label,
                    'url' => $url,
                ];
            }
        }

        return $items;
    }
}
