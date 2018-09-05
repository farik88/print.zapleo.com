<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "product_sale".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $sale_id
 *
 * @property \common\models\Products $product
 * @property \common\models\Sales $sale
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
            'product_id' => 'Product ID',
            'sale_id' => 'Sale ID',
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
    public function getSale()
    {
        return $this->hasOne(\common\models\Sales::className(), ['id' => 'sale_id']);
            
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveSale()
    {
        return $this->hasOne(\common\models\Sales::className(), ['id' => 'sale_id'])->where(['active'=>1])
            ->addSelect("*, (if(type <>1, CONCAT('UAH'), CONCAT('%'))) AS type_text ");
    }


}
