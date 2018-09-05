<?php

namespace common\models;

use \common\models\base\LangMessage as BaseLangMessage;

/**
 * This is the model class for table "message".
 */
class LangMessage extends BaseLangMessage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16]
        ]);
    }
	
}
