<?php

namespace backend\models;

use \backend\models\base\OrderProduct as BaseOrderProduct;

/**
 * This is the model class for table "order_product".
 */
class OrderProduct extends BaseOrderProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['product_id', 'image_id', 'total', 'count','cover_id', 'color_id'], 'required'],
            [['product_id', 'order_id', 'image_id', 'total', 'count', 'created_at', 'updated_at', 'cover_id', 'color_id'], 'integer']
        ]);
    }
	
}
