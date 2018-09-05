<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "orders".
 *
 * @property integer $id
 * @property integer $delivery_id
 * @property integer $payment_id
 * @property integer $coupon_id
 * @property integer $user_id
 * @property integer $total
 * @property string $comment
 * @property integer $status_payment
 * @property integer $status_delivery
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $address
 *
 * @property \backend\models\OrderCart[] $orderCarts
 * @property \backend\models\Deliveries $delivery
 * @property \backend\models\Coupons $coupon
 * @property \backend\models\Users $user
 * @property \backend\models\Payments $payment
 */
class Orders extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    const PAYMENT_ACCEPTED = 0;
    const PAYMENT_EXPECTATION =1;
    const PAYMENT_ERROR = 2;

    const DELIVERY_ACCEPTED = 0;
    const DELIVERY_ON_MY_WAY = 1;
    const DELIVERY_EXPECTATION = 2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_id', 'payment_id', 'user_id', 'total', 'status_payment', 'status_delivery', 'data', 'address'], 'required'],
            [['delivery_id', 'payment_id', 'coupon_id', 'user_id',  'status_payment', 'status_delivery', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['total'],'double'],
            [['data'], 'safe'],
            [['address'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_id' => Yii::t('frontend_orders','Доставка'),
            'payment_id' => Yii::t('frontend_orders','Оплата'),
            'coupon_id' => Yii::t('frontend_orders','Купон'),
            'user_id' => Yii::t('frontend_orders','Пользователь'),
            'total' => Yii::t('frontend_orders','Сумма'),
            'comment' => Yii::t('frontend_orders','Коментарий'),
            'status_payment' => Yii::t('frontend_orders','Статус оплаты'),
            'status_delivery' => Yii::t('frontend_orders','Статус доставки'),
            'data' => Yii::t('frontend_orders','Дата'),
            'address' => Yii::t('frontend_orders','Адрес'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderCarts()
    {
        return $this->hasMany(\common\models\OrderCart::className(), ['order_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasOne(\common\models\Deliveries::className(), ['id' => 'delivery_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(\common\models\Coupons::className(), ['id' => 'coupon_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\common\models\Users::className(), ['id' => 'user_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(\common\models\Payments::className(), ['id' => 'payment_id']);
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
