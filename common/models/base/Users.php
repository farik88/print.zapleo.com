<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property \common\models\Orders[] $orders
 */
class Users extends \common\components\base\BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'required','message'=>'{attribute} не может быть пустым'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['phone'], 'string'],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['last_active'],'safe'],
            [['password_reset_token'], 'unique']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => Yii::t('frontend_users','Имя'),
            'auth_key' => Yii::t('frontend_users','Пароль'),
            'password_hash' => Yii::t('frontend_users','Password Hash'),
            'password_reset_token' => Yii::t('frontend_users','Password Reset Token'),
            'email' => Yii::t('frontend_users','Email'),
            'status' => Yii::t('frontend_users','Статус'),
            'last_active' => Yii::t('frontend_users','Последняя активность'),
            'created_at' => Yii::t('frontend_users','Добавлен'),
            'updated_at' => Yii::t('frontend_users','Обновлен'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(\common\models\Orders::className(), ['user_id' => 'id']);
    }
    
/**
     * @inheritdoc
     * @return array mixed
     */ 
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
        ];
    }
}
