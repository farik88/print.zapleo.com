<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "product_color".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $color_id
 * @property integer $file_id
 *
 * @property \common\models\Products $product
 * @property \common\models\Colors $color
 * @property \common\models\Files $file
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
            'product_id' => 'Product ID',
            'color_id' => 'Color ID',
            'file_id' => 'File ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(\common\models\Products::className(), ['id' => 'product_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(\common\models\Colors::className(), ['id' => 'color_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\common\models\Files::className(), ['id' => 'file_id']);
    }
    }
