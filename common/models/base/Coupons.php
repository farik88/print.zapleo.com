<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "coupons".
 *
 * @property integer $id
 * @property string $hash
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $value
 * @property integer $discount_type
 * @property integer $active
 * @property integer $type
 *
 * @property \backend\models\CouponCover[] $couponCovers
 * @property \backend\models\CouponLabel[] $couponLabels
 * @property \backend\models\Orders[] $orders
 * @property \backend\models\ProductCoupon[] $productCoupons
 */
class Coupons extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    const ACTIVE = 1;
    const DISABLED = 0;

    const TYPE_PERCENT = 0;
    const TYPE_CURRENCY = 1;

    const TYPE_PRODUCT = 0;
    const TYPE_LABEL = 1;
    const TYPE_COVER = 2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hash','value', 'discount_type'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'value', 'discount_type', 'active', 'type'], 'integer'],
            [['hash'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupons';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash' => Yii::t('frontend_coupons','Код'),
            'value' => Yii::t('frontend_coupons','Значение'),
            'discount_type' => Yii::t('frontend_coupons','Тип дисконта'),
            'active' => Yii::t('frontend_coupons','Статуст'),
            'type' => Yii::t('frontend_coupons','Тип'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCouponCovers()
    {
        return $this->hasMany(\common\models\CouponCover::className(), ['coupon_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCouponLabels()
    {
        return $this->hasMany(\common\models\CouponLabel::className(), ['coupon_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(\common\models\Orders::className(), ['coupon_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCoupons()
    {
        return $this->hasMany(\common\models\ProductCoupon::className(), ['coupon_id' => 'id']);
    }
    
/**
     * @inheritdoc
     * @return array mixed
     */ 
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' =>null,
            ],
        ];
    }
}
