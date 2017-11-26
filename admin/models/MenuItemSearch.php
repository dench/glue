<?php

namespace app\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MenuItem;

/**
 * MenuItemSearch represents the model behind the search form about `app\models\MenuItem`.
 */
class MenuItemSearch extends MenuItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'menu_id', 'parent_id', 'position', 'enabled'], 'integer'],
            [['icon', 'url', 'link', 'label'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MenuItem::find();

        $query->joinWith('translation');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'position' => SORT_ASC,
                ],
            ],
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere(['parent_id' => $this->parent_id ? $this->parent_id : null]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'menu_id' => $this->menu_id,
            'position' => $this->position,
            'enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'label', $this->label]);

        return $dataProvider;
    }
}
