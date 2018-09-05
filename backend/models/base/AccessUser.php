<?php

namespace backend\models\base;

use Yii;

/**
 * This is the base model class for table "access_user".
 *
 * @property integer $id
 * @property integer $access_id
 * @property integer $user_id
 *
 * @property \backend\models\Accesses $access
 * @property \backend\models\Users $user
 */
class AccessUser extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['access_id', 'user_id'], 'required'],
            [['access_id', 'user_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_user';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_id' => 'Доступ',
            'user_id' => 'Пользователь',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccess()
    {
        return $this->hasOne(\backend\models\Accesses::className(), ['id' => 'access_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\backend\models\Users::className(), ['id' => 'user_id']);
    }
    }
