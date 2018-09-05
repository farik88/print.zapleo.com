<?php

namespace common\models;

use \common\models\base\ProductMarking as BaseProductMarking;

/**
 * This is the model class for table "product_marking".
 */
class ProductMarking extends BaseProductMarking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['product_id', 'marking_id'], 'required'],
            [['product_id', 'marking_id'], 'integer']
        ]);
    }
	
}
