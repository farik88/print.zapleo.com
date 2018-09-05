<?php

namespace common\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "deliveries".
 *
 * @property integer $id
 * @property string $title
 * @property integer $file_id
 * @property string $comment
 * @property integer $price
 * @property integer $active
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\Files $file
 * @property \common\models\Orders[] $orders
 */
class Deliveries extends \common\components\base\BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'file_id', 'price', 'active'], 'required','message'=>'{attribute} не может быть пустым'],
            [['file_id', 'price', 'active', 'created_by', 'updated_by'], 'integer'],
            [['comment'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deliveries';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('frontend_deliveries','Название'),
            'file_id' => Yii::t('frontend_deliveries','Изображение'),
            'comment' => Yii::t('frontend_deliveries','Описание'),
            'price' => Yii::t('frontend_deliveries','Цена'),
            'active' => Yii::t('frontend_deliveries','Статус'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\common\models\Files::className(), ['id' => 'file_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(\common\models\Orders::className(), ['delivery_id' => 'id']);
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
                'value' => time()
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }
}
