<?php

namespace backend\models\base;

use Yii;

/**
 * This is the base model class for table "colors".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property \backend\models\ProductColor[] $productColors
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
            'name' => Yii::t('backend_colors','Название'),
            'code' => Yii::t('backend_colors','Код цвета'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductColors()
    {
        return $this->hasMany(\backend\models\ProductColor::className(), ['color_id' => 'id']);
    }
    }
