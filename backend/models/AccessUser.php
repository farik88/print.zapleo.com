<?php

namespace backend\models;

use \backend\models\base\AccessUser as BaseAccessUser;

/**
 * This is the model class for table "access_user".
 */
class AccessUser extends BaseAccessUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['access_id', 'user_id'], 'required'],
            [['access_id', 'user_id'], 'integer']
        ]);
    }
	
}
