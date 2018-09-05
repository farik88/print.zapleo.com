<?php

namespace common\models;

use \common\models\base\Users as BaseUsers;

/**
 * This is the model class for table "users".
 */
class Users extends BaseUsers
{
    const SCENARIO_PROFILE_EDIT= 'profile_edit';
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
            [['phone'], 'string'],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['last_active'],'safe'],
            [['password_reset_token'], 'unique']
        ]);
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'username', 'auth_key', 'password_hash', 'email','status', 'created_at',
                'updated_at', 'password_reset_token', 'phone', 'last_active'],
            self::SCENARIO_PROFILE_EDIT => ['username', 'email', 'password'],
        ];
    }
	
}
