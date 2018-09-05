<?php

namespace backend\models\base;

use Yii;

/**
 * This is the base model class for table "product_coupon".
 *
 * @property integer $id
 * @property integer $coupon_id
 * @property integer $product_id
 *
 * @property \backend\models\Coupons $coupon
 * @property \backend\models\Products $product
 */
class ProductCoupon extends \common\components\base\BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coupon_id', 'product_id'], 'required'],
            [['coupon_id', 'product_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_coupon';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coupon_id' => 'Купон',
            'product_id' => 'Товар',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(\backend\models\Coupons::className(), ['id' => 'coupon_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(\backend\models\Products::className(), ['id' => 'product_id']);
    }
    }
