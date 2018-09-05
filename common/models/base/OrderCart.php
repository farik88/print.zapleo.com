<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "order_cart".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $order_id
 * @property integer $image_id
 * @property integer $total
 * @property integer $count
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $cover_id
 * @property string $user_hash
 * @property integer $color_id
 * @property integer $user_id
 * @property integer $coupon_id
 *
 * @property \backend\models\Products $product
 * @property \backend\models\Orders $order
 * @property \backend\models\Images $image
 * @property \backend\models\Covers $cover
 * @property \backend\models\Colors $color
 * @property \backend\models\Coupons $coupon
 */
class OrderCart extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'image_id', 'total', 'count','cover_id', 'color_id'], 'required'],
            [['product_id', 'order_id', 'image_id', 'count', 'created_at', 'updated_at', 'cover_id', 'color_id', 'user_id', 'coupon_id'], 'integer'],
            [['total'],'double'],
            [['user_hash'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_cart';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => Yii::t('frontend_ordercart','Товар'),
            'order_id' => Yii::t('frontend_ordercart','Заказ'),
            'image_id' => Yii::t('frontend_ordercart','Изображение'),
            'total' => Yii::t('frontend_ordercart','Сумма'),
            'count' => Yii::t('frontend_ordercart','Количество'),
            'cover_id' => Yii::t('frontend_ordercart','Чехол'),
            'user_hash' => Yii::t('frontend_ordercart','User Hash'),
            'color_id' => Yii::t('frontend_ordercart','Цвет'),
            'user_id' => Yii::t('frontend_ordercart','User ID'),
            'coupon_id' => Yii::t('frontend_ordercart','Купон'),
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
    public function getOrder()
    {
        return $this->hasOne(\common\models\Orders::className(), ['id' => 'order_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(\common\models\Images::className(), ['id' => 'image_id']);
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
    public function getColor()
    {
        return $this->hasOne(\common\models\Colors::className(), ['id' => 'color_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(\common\models\Coupons::className(), ['id' => 'coupon_id']);
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
        ];
    }
}
