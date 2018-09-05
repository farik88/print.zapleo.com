<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "settings".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property string $description
 */
class SettingRecord extends \frontend\core\base\FrontendActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['description'], 'string'],
            [['key', 'value'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => Yii::t('backend_settings','Ключ'),
            'value' => Yii::t('backend_settings','Значение'),
            'description' => Yii::t('backend_settings','Описание'),
        ];
    }
}
