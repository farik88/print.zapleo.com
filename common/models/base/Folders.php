<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "folders".
 *
 * @property integer $id
 * @property integer $parent_folder
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property integer $type_id
 *
 * @property \common\models\Resources[] $resources
 */
class Folders extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;


    const TYPE_EMOJI = 0;
    const TYPE_FONTS = 1;
    const TYPE_BACKGROUND = 2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_folder', 'created_at', 'updated_at', 'type_id'], 'integer'],
            [['name', 'type_id'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'folders';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_folder' => Yii::t('frontend_folders', 'Родительская папка'),
            'name' => Yii::t('frontend_folders','Имя'),
            'type_id' => Yii::t('frontend_folders','Тип'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResources()
    {
        return $this->hasMany(\common\models\Resources::className(), ['folder_id' => 'id']);
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
//            'blameable' => [
//                'class' => BlameableBehavior::className(),
//                'createdByAttribute' => 'created_by',
//                'updatedByAttribute' => 'updated_by',
//            ],
        ];
    }
}
