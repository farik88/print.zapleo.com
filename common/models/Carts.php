<?php

namespace common\models;

use \common\models\base\Carts as BaseCarts;

/**
 * This is the model class for table "carts".
 */
class Carts extends BaseCarts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['product_id', 'image_id', 'total', 'count', 'cover_id', 'user_hash', 'color_id'], 'required'],
            [['product_id', 'order_id', 'image_id', 'total', 'count', 'created_at', 'updated_at', 'cover_id', 'color_id'], 'integer'],
            [['user_hash'], 'string', 'max' => 255]
        ]);
    }
	
}
