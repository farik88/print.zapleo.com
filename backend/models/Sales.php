<?php

namespace backend\models;

use \backend\models\base\Sales as BaseSales;

/**
 * This is the model class for table "sales".
 */
class Sales extends BaseSales
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['value', 'type'], 'required'],
            [['value', 'created_at', 'updated_at', 'created_by', 'updated_by', 'type', 'active'], 'integer'],
            [['data_start', 'data_end'], 'safe']
        ]);
    }
	
}
