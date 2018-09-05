<?php

namespace backend\models;

use \backend\models\base\ProductLabel as BaseProductLabel;

/**
 * This is the model class for table "product_label".
 */
class ProductLabel extends BaseProductLabel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['product_id', 'label_id'], 'required'],
            [['product_id', 'label_id'], 'integer']
        ]);
    }
	
}
