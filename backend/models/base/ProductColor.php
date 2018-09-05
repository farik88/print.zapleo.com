<?php

namespace backend\models\base;

use Yii;

/**
 * This is the base model class for table "product_color".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $color_id
 * @property integer $file_id
 *
 * @property \backend\models\Products $product
 * @property \backend\models\Colors $color
 * @property \backend\models\Files $file
 */
class ProductColor extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'color_id', 'file_id'], 'required'],
            [['product_id', 'color_id', 'file_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_color';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товары',
            'color_id' => 'Цвет',
            'file_id' => 'Изображение',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(\backend\models\Products::className(), ['id' => 'product_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(\backend\models\Colors::className(), ['id' => 'color_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\backend\models\Files::className(), ['id' => 'file_id']);
    }
    }
