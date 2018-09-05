<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Deliveries;

/**
 * common\models\DeliveriesSearch represents the model behind the search form about `common\models\Deliveries`.
 */
 class DeliveriesSearch extends Deliveries
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'file_id', 'price', 'active', 'created_by', 'updated_by'], 'integer'],
            [['title', 'comment'], 'safe'],
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
        $query = Deliveries::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'file_id' => $this->file_id,
            'price' => $this->price,
            'active' => $this->active,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
