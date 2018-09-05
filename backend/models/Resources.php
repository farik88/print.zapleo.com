<?php

namespace backend\models;

use \backend\models\base\Resources as BaseResources;

/**
 * This is the model class for table "resources".
 */
class Resources extends BaseResources
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'ext', 'title'], 'required'],
            [['folder_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'ext', 'title'], 'string', 'max' => 255]
        ]);
    }
	
}
