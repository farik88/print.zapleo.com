<?php

namespace common\models;

use \common\models\base\Images as BaseImages;

/**
 * This is the model class for table "images".
 */
class Images extends BaseImages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['title', 'name', 'ext'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'name', 'ext'], 'string', 'max' => 255]
        ]);
    }
	
}
