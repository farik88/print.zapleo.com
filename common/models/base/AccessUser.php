<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "access_user".
 *
 * @property integer $id
 * @property integer $access_id
 * @property integer $user_id
 *
 * @property \common\models\Accesses $access
 * @property \common\models\Users $user
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
            'access_id' => 'Access ID',
            'user_id' => 'User ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccess()
    {
        return $this->hasOne(\common\models\Accesses::className(), ['id' => 'access_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\common\models\Users::className(), ['id' => 'user_id']);
    }
    }
