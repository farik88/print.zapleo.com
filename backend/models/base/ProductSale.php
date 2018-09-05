<?php

namespace backend\models\base;

use Yii;

/**
 * This is the base model class for table "product_sale".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $sale_id
 *
 * @property \backend\models\Products $product
 * @property \backend\models\Sales $sale
 */
class ProductSale extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'sale_id'], 'required'],
            [['product_id', 'sale_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_sale';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'sale_id' => 'Акция',
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
    public function getSale()
    {
        return $this->hasOne(\backend\models\Sales::className(), ['id' => 'sale_id']);
    }
    }
