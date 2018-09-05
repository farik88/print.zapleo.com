<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "sales".
 *
 * @property integer $id
 * @property integer $value
 * @property string $data_start
 * @property string $data_end
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $type
 * @property integer $active
 *
 * @property \backend\models\CoverSale[] $coverSales
 * @property \backend\models\LabelSale[] $labelSales
 * @property \backend\models\ProductSale[] $productSales
 */
class Sales extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    const PERCENT = 1;
    const CURRENCY = 0;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'type'], 'required'],
            [['value', 'created_at', 'updated_at', 'created_by', 'updated_by', 'type', 'active'], 'integer'],
            [['data_start', 'data_end'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sales';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => Yii::t('backend_sales','Значение'),
            'data_start' => Yii::t('backend_sales','Дата начала'),
            'data_end' => Yii::t('backend_sales','Дата оканчания'),
            'type' => Yii::t('backend_sales','Тип'),
            'active' => Yii::t('backend_sales','Статус'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoverSales()
    {
        return $this->hasMany(\backend\models\CoverSale::className(), ['sale_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabelSales()
    {
        return $this->hasMany(\backend\models\LabelSale::className(), ['sale_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSales()
    {
        return $this->hasMany(\backend\models\ProductSale::className(), ['sale_id' => 'id']);
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
