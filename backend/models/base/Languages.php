<?php

namespace backend\models\base;

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
 * @property \backend\models\Files $file
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
            [['title', 'file_id', 'url', 'iso_code'], 'required'],
            [['active', 'file_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['comment', 'iso_code', 'url'], 'string'],
            [['title'], 'string', 'max' => 255]
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
            'title' => Yii::t('backend_languages','Название'),
            'active' => Yii::t('backend_languages','Статус'),
            'comment' => Yii::t('backend_languages','Комментарий'),
            'file_id' => Yii::t('backend_languages','Изображение'),
            'url'   => Yii::t('backend_languages','URL языка')
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\backend\models\Files::className(), ['id' => 'file_id']);
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
