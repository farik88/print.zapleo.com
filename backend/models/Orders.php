<?php

namespace backend\models;

use \backend\models\base\Orders as BaseOrders;

/**
 * This is the model class for table "orders".
 */
class Orders extends BaseOrders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['delivery_id', 'payment_id', 'user_id', 'total', 'status_payment', 'status_delivery', 'data', 'address'], 'required'],
            [['delivery_id', 'payment_id', 'coupon_id', 'user_id', 'total', 'status_payment', 'status_delivery', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['data'], 'safe'],
            [['address'], 'string', 'max' => 255]
        ]);
    }
	
}
