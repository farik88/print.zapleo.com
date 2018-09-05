<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductMarking;

/**
 * backend\models\ProductMarkingSearch represents the model behind the search form about `backend\models\ProductMarking`.
 */
 class ProductMarkingSearch extends ProductMarking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price', 'created_at', 'updated_at', 'created_by', 'updated_by', 'file_id', 'wspace_width', 'wspace_height', 'wspace_width3d', 'wspace_height3d'], 'integer'],
            [['name'], 'safe'],
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
        $query = ProductMarking::find();

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
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'file_id' => $this->file_id,
            'wspace_width' => $this->wspace_width,
            'wspace_height' => $this->wspace_height,
            'wspace_width3d' => $this->wspace_width3d,
            'wspace_height3d' => $this->wspace_height3d,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
