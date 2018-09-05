<?php

namespace common\models;

use \common\models\base\LabelSale as BaseLabelSale;

/**
 * This is the model class for table "label_sale".
 */
class LabelSale extends BaseLabelSale
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['label_id', 'sale_id'], 'required'],
            [['label_id', 'sale_id'], 'integer']
        ]);
    }
	
}
