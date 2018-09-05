<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "resources".
 *
 * @property integer $id
 * @property integer $folder_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $ext
 * @property string $title
 * @property integer $type_id
 *
 * @property \common\models\Folders $folder
 */
class Resources extends \common\components\base\BaseActiveRecord
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
            [['name', 'ext', 'title'], 'required'],
            [['folder_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'ext', 'title'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resources';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'folder_id' => Yii::t('frontend_resources','Папка'),
            'name' => Yii::t('frontend_resources','Имя'),
            'ext' => Yii::t('frontend_resources','Расширение'),
            'title' => Yii::t('frontend_resources','Название'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolder()
    {
        return $this->hasOne(\common\models\Folders::className(), ['id' => 'folder_id']);
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
