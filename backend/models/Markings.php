<?php

namespace backend\models;

use \backend\models\base\Markings as BaseMarkings;

/**
 * This is the model class for table "markings".
 */
class Markings extends BaseMarkings
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['title', 'name'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'name'], 'string', 'max' => 255]
        ]);
    }
	
}
