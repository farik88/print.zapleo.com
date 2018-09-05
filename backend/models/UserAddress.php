<?php

namespace backend\models;

use \backend\models\base\UserAddress as BaseUserAddress;

/**
 * This is the model class for table "user_address".
 */
class UserAddress extends BaseUserAddress
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['user_id', 'address'], 'required'],
            [['user_id'], 'integer'],
            [['address'], 'string', 'max' => 255]
        ]);
    }
	
}
