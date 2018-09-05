<?php

namespace backend\models;

use \backend\models\base\Users as BaseUsers;

/**
 * This is the model class for table "users".
 */
class Users extends BaseUsers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['username', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['last_active'],'safe'],
            [['password_reset_token'], 'unique']
        ]);
    }
	
}
