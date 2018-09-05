<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Orders;

/**
 * backend\models\OrdersSearch represents the model behind the search form about `backend\models\Orders`.
 */
 class OrdersSearch extends Orders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'delivery_id', 'payment_id', 'coupon_id', 'user_id', 'total', 'status_payment', 'status_delivery', 'created_at', 'updated_at'], 'integer'],
            [['comment', 'data', 'address'], 'safe'],
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
        $query = Orders::find()->orderBy('id DESC');

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
            'delivery_id' => $this->delivery_id,
            'payment_id' => $this->payment_id,
            'coupon_id' => $this->coupon_id,
            'user_id' => $this->user_id,
            'total' => $this->total,
            'status_payment' => $this->status_payment,
            'status_delivery' => $this->status_delivery,
            'data' => $this->data,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
