<?php

namespace artlosk\tags\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use artlosk\tags\models\Tag;

/**
 * TagSearch represents the model behind the search form about `artlosk\tags\models\Tag`.
 */
class TagSearch extends Tag
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'frequency', 'hidden'], 'integer'],
            [['name', 'createdAt', 'updatedAt'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
        $query = Tag::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['frequency' => SORT_DESC]]

        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'frequency' => $this->frequency,
            'hidden' => $this->hidden,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'createdAt', $this->createdAt])
            ->andFilterWhere(['like', 'updatedAt', $this->updatedAt]);

        return $dataProvider;
    }
}
