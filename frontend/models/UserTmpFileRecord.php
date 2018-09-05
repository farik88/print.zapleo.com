<?php

namespace frontend\models;

use \frontend\models\base\UserTmpFileRecord as BaseUserTmpFileRecord;

/**
 * This is the model class for table "user_tmp_files".
 */
class UserTmpFileRecord extends BaseUserTmpFileRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'ext'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'ext', 'owner_hash'], 'string', 'max' => 255],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
