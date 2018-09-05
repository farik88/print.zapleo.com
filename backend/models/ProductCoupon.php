<?php

namespace backend\models;

use \backend\models\base\ProductCoupon as BaseProductCoupon;

/**
 * This is the model class for table "product_coupon".
 */
class ProductCoupon extends BaseProductCoupon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['coupon_id', 'product_id'], 'required'],
            [['coupon_id', 'product_id'], 'integer']
        ]);
    }
	
}
