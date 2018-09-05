<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "languages".
 *
 * @property integer $id
 * @property string $title
 * @property integer $active
 * @property string $comment
 * @property integer $file_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\Files $file
 */
class Languages extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    const LANG_ACTIVE = 1;
    const LANG_DISABLED = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['active', 'file_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_default'], 'integer'],
            [['comment'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['iso_code'], 'string', 'max' => 10],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'active' => 'Статус',
            'comment' => 'Комментарий',
            'file_id' => 'Изображение',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\common\models\Files::className(), ['id' => 'file_id']);
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
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }
}
