<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "colors".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property \common\models\ProductColor[] $productColors
 */
class Colors extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['name', 'code'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'colors';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('colors','Название'),
            'code' => Yii::t('colors','Код цвета'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductColors()
    {
        return $this->hasMany(\common\models\ProductColor::className(), ['color_id' => 'id']);
    }
    }
