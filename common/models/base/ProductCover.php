<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "product_cover".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $cover_id
 *
 * @property \common\models\Products $product
 * @property \common\models\Covers $cover
 */
class ProductCover extends \common\components\base\BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'cover_id','file_id'], 'required'],
            [['product_id', 'cover_id','file_id'], 'integer']
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
            'product_id' => 'Product ID',
            'cover_id' => 'Cover ID',
            'file_id' => 'File ID'
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
    public function getCover()
    {
        return $this->hasOne(\common\models\Covers::className(), ['id' => 'cover_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\common\models\Files::className(), ['id' => 'file_id']);
    }
    }
