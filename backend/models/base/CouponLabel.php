<?php

namespace backend\models\base;

use Yii;

/**
 * This is the base model class for table "coupon_label".
 *
 * @property integer $id
 * @property integer $coupon_id
 * @property integer $label_id
 *
 * @property \backend\models\Labels $label
 * @property \backend\models\Coupons $coupon
 */
class CouponLabel extends \common\components\base\BaseActiveRecord
{


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coupon_id', 'label_id'], 'required'],
            [['coupon_id', 'label_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon_label';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coupon_id' => 'Купон',
            'label_id' => 'Метка',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabel()
    {
        return $this->hasOne(\backend\models\Labels::className(), ['id' => 'label_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(\backend\models\Coupons::className(), ['id' => 'coupon_id']);
    }
    }
