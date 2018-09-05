<?php

namespace backend\models;

use \backend\models\base\Languages as BaseLanguages;

/**
 * This is the model class for table "languages".
 */
class Languages extends BaseLanguages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['title', 'file_id'], 'required'],
            [['active', 'file_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['comment'], 'string'],
            [['title'], 'string', 'max' => 255]
        ]);
    }
	
}
