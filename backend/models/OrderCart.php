<?php

namespace backend\models;

use \backend\models\base\OrderCart as BaseOrderCart;

/**
 * This is the model class for table "order_cart".
 */
class OrderCart extends BaseOrderCart
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['product_id', 'image_id', 'total', 'count','cover_id', 'color_id'], 'required'],
            [['product_id', 'order_id', 'image_id', 'total', 'count', 'created_at', 'updated_at', 'cover_id', 'color_id', 'user_id', 'coupon_id'], 'integer'],
            [['user_hash'], 'string', 'max' => 255]
        ]);
    }
	
}
