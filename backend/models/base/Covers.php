<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "covers".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $file_id
 * @property integer $active
 * @property string $title
 *
 * @property \backend\models\CouponCover[] $couponCovers
 * @property \backend\models\CoverSale[] $coverSales
 * @property \backend\models\Files $file
 * @property \backend\models\ProductCover[] $productCovers
 */
class Covers extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_by', 'updated_by', 'file_id', 'active'], 'integer'],
            [['name', 'title'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'covers';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('backend_covers','Имя'),
            'file_id' => Yii::t('backend_covers','Файл'),
            'active' => Yii::t('backend_covers','Статус'),
            'title' => Yii::t('backend_covers','Название'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCouponCovers()
    {
        return $this->hasMany(\backend\models\CouponCover::className(), ['cover_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoverSales()
    {
        return $this->hasMany(\backend\models\CoverSale::className(), ['cover_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\backend\models\Files::className(), ['id' => 'file_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCovers()
    {
        return $this->hasMany(\backend\models\ProductCover::className(), ['cover_id' => 'id']);
    }
    
/**
     * @inheritdoc
     * @return array mixed
     */ 
    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }
}
