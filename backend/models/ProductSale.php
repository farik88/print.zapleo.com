<?php

namespace backend\models;

use \backend\models\base\ProductSale as BaseProductSale;

/**
 * This is the model class for table "product_sale".
 */
class ProductSale extends BaseProductSale
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['product_id', 'sale_id'], 'required'],
            [['product_id', 'sale_id'], 'integer']
        ]);
    }
	
}
