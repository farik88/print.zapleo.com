<?php

namespace common\models;

use \common\models\base\CoverSale as BaseCoverSale;

/**
 * This is the model class for table "cover_sale".
 */
class CoverSale extends BaseCoverSale
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['sale_id', 'cover_id'], 'required'],
            [['sale_id', 'cover_id'], 'integer']
        ]);
    }
	
}
