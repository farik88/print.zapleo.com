<?php

namespace backend\models;

use \backend\models\base\Coupons as BaseCoupons;

/**
 * This is the model class for table "coupons".
 */
class Coupons extends BaseCoupons
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['hash','value', 'discount_type'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'value', 'discount_type', 'active', 'type'], 'integer'],
            [['hash'], 'string', 'max' => 255]
        ]);
    }
	
}
