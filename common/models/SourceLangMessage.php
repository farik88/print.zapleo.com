<?php

namespace common\models;

use \common\models\base\SourceLangMessage as BaseSourceLangMessage;

/**
 * This is the model class for table "source_message".
 */
class SourceLangMessage extends BaseSourceLangMessage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['message'], 'string'],
            [['category'], 'string', 'max' => 255]
        ]);
    }
	
}
