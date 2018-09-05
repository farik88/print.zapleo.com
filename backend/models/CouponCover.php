<?php

namespace backend\models;

use \backend\models\base\CouponCover as BaseCouponCover;

/**
 * This is the model class for table "coupon_cover".
 */
class CouponCover extends BaseCouponCover
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['coupon_id', 'cover_id'], 'required'],
            [['coupon_id', 'cover_id'], 'integer']
        ]);
    }
	
}
