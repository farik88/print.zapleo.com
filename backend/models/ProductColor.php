<?php

namespace backend\models;

use \backend\models\base\ProductColor as BaseProductColor;

/**
 * This is the model class for table "product_color".
 */
class ProductColor extends BaseProductColor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['product_id', 'color_id', 'file_id'], 'required'],
            [['product_id', 'color_id', 'file_id'], 'integer']
        ]);
    }
	
}
