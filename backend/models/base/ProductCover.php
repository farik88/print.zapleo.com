<?php

namespace backend\models\base;

use Yii;

/**
 * This is the base model class for table "product_cover".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $cover_id
 * @property integer $file_id
 * @property integer $color_id
 *
 * @property \backend\models\Products $product
 * @property \backend\models\Covers $cover
 * @property \backend\models\Files $file
 * @property \backend\models\Colors $color
 */
class ProductCover extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'cover_id', 'file_id'], 'required'],
            [['product_id', 'cover_id', 'file_id', 'color_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_cover';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'cover_id' => 'Чехол',
            'file_id' => 'Изображение',
            'color_id' => 'Цвет',
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
    public function getCover()
    {
        return $this->hasOne(\backend\models\Covers::className(), ['id' => 'cover_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\backend\models\Files::className(), ['id' => 'file_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(\backend\models\Colors::className(), ['id' => 'color_id']);
    }
    }
