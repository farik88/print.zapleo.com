<?php

namespace common\models;

use \common\models\base\Accesses as BaseAccesses;

/**
 * This is the model class for table "accesses".
 */
class Accesses extends BaseAccesses
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['title', 'value'], 'required'],
            [['value', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ]);
    }
	
}
