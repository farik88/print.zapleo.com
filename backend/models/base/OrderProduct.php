<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "order_product".
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
 * @property integer $color_id
 *
 * @property \backend\models\Products $product
 * @property \backend\models\Orders $order
 * @property \backend\models\Images $image
 * @property \backend\models\Covers $cover
 * @property \backend\models\Colors $color
 */
class OrderProduct extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'image_id', 'total', 'count','cover_id', 'color_id'], 'required'],
            [['product_id', 'order_id', 'image_id', 'total', 'count', 'created_at', 'updated_at', 'cover_id', 'color_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_product';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'order_id' => 'Заказ',
            'image_id' => 'Изображение',
            'total' => 'Сумма',
            'count' => 'Количество',
            'cover_id' => 'Чехол',
            'color_id' => 'Цвет',
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
    public function getOrder()
    {
        return $this->hasOne(\backend\models\Orders::className(), ['id' => 'order_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(\backend\models\Images::className(), ['id' => 'image_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCover()
    {
        return $this->hasOne(\backend\models\Covers::className(), ['id' => 'cover_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(\backend\models\Colors::className(), ['id' => 'color_id']);
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
