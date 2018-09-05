<?php

namespace backend\models\base;

use Yii;

/**
 * This is the base model class for table "user_address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $address
 *
 * @property \backend\models\Users $user
 */
class UserAddress extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'address'], 'required'],
            [['user_id'], 'integer'],
            [['address'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_address';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'address' => 'Адресс',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\backend\models\Users::className(), ['id' => 'user_id']);
    }
    }
