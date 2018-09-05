<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "coupon_cover".
 *
 * @property integer $id
 * @property integer $coupon_id
 * @property integer $cover_id
 *
 * @property \common\models\Coupons $coupon
 * @property \common\models\Covers $cover
 */
class CouponCover extends \common\components\base\BaseActiveRecord
{



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coupon_id', 'cover_id'], 'required'],
            [['coupon_id', 'cover_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon_cover';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coupon_id' => 'Coupon ID',
            'cover_id' => 'Cover ID',
        ];
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
    public function getCover()
    {
        return $this->hasOne(\common\models\Covers::className(), ['id' => 'cover_id']);
    }

    public static function comparedKey() {
        return 'cover_id';
    }
    }
