<?php

namespace backend\models;

use \backend\models\base\CouponLabel as BaseCouponLabel;

/**
 * This is the model class for table "coupon_label".
 */
class CouponLabel extends BaseCouponLabel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['coupon_id', 'label_id'], 'required'],
            [['coupon_id', 'label_id'], 'integer']
        ]);
    }
	
}
