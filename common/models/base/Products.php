<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "products".
 *
 * @property integer $id
 * @property string $name
 * @property integer $price
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $file_id
 * @property integer $wspace_width
 * @property integer $wspace_height
 * @property integer $wspace_width3d
 * @property integer $wspace_height3d
 * @property integer $active
 * @property integer $position
 *
 * @property \backend\models\OrderCart[] $orderCarts
 * @property \backend\models\ProductColor[] $productColors
 * @property \backend\models\ProductCoupon[] $productCoupons
 * @property \backend\models\ProductCover[] $productCovers
 * @property \backend\models\ProductLabel[] $productLabels
 * @property \backend\models\ProductMarking[] $productMarkings
 * @property \backend\models\ProductSale[] $productSales
 * @property \backend\models\Files $file
 */
class Products extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'created_at', 'updated_at', 'created_by', 'updated_by', 'file_id', 'wspace_width', 'wspace_height', 'wspace_width3d', 'wspace_height3d', 'active', 'position'], 'integer'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'file_id'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('frontend_products','Имя'),
            'price' => Yii::t('frontend_products','Цена'),
            'file_id' => Yii::t('frontend_products','Изображение'),
            'wspace_width' => Yii::t('frontend_products','Ширина'),
            'wspace_height' => Yii::t('frontend_products','Высота'),
            'wspace_width3d' => Yii::t('frontend_products','Ширина3d'),
            'wspace_height3d' => Yii::t('frontend_products','Высота3d'),
            'active' => Yii::t('frontend_products','Статус'),
            'position' => Yii::t('frontend_products','Позиция'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderCarts()
    {
        return $this->hasMany(\common\models\OrderCart::className(), ['product_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductColors()
    {
        return $this->hasMany(\common\models\ProductColor::className(), ['product_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCoupons()
    {
        return $this->hasMany(\common\models\ProductCoupon::className(), ['product_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCovers()
    {
        return $this->hasMany(\common\models\ProductCover::className(), ['product_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductLabels()
    {
        return $this->hasMany(\common\models\ProductLabel::className(), ['product_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductMarkings()
    {
        return $this->hasMany(\common\models\ProductMarking::className(), ['product_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSales()
    {
        return $this->hasMany(\common\models\ProductSale::className(), ['product_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\common\models\Files::className(), ['id' => 'file_id']);
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
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }
}
