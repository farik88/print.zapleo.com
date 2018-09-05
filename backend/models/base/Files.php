<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "files".
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property string $ext
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property \backend\models\Deliveries[] $deliveries
 * @property \backend\models\Payments[] $payments
 * @property \backend\models\ProductColor[] $productColors
 * @property \backend\models\ProductCover[] $productCovers
 * @property \backend\models\Products[] $products
 */
class Files extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'ext'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'name', 'ext'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'name' => 'Имя',
            'ext' => 'Расширение',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveries()
    {
        return $this->hasMany(\backend\models\Deliveries::className(), ['file_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(\backend\models\Payments::className(), ['file_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductColors()
    {
        return $this->hasMany(\backend\models\ProductColor::className(), ['file_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCovers()
    {
        return $this->hasMany(\backend\models\ProductCover::className(), ['file_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(\backend\models\Products::className(), ['file_id' => 'id']);
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
