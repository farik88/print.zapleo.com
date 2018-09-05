<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "labels".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \backend\models\CouponLabel[] $couponLabels
 * @property \backend\models\LabelSale[] $labelSales
 * @property \backend\models\ProductLabel[] $productLabels
 */
class Labels extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'labels';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('backend_labels','Название'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCouponLabels()
    {
        return $this->hasMany(\backend\models\CouponLabel::className(), ['label_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabelSales()
    {
        return $this->hasMany(\backend\models\LabelSale::className(), ['label_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductLabels()
    {
        return $this->hasMany(\backend\models\ProductLabel::className(), ['label_id' => 'id']);
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
