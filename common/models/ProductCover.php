<?php

namespace common\models;

use \common\models\base\ProductCover as BaseProductCover;

/**
 * This is the model class for table "product_cover".
 */
class ProductCover extends BaseProductCover
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['product_id', 'cover_id','file_id'], 'required'],
            [['product_id', 'cover_id','file_id'], 'integer']
        ]);
    }
	
}
